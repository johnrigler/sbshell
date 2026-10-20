// Run with: SB_PHP=php8.2 node tests/clipboard-cli.mjs (no packages required).
import assert from 'node:assert/strict';
import {spawn, spawnSync} from 'node:child_process';
import {mkdtemp, mkdir, writeFile, rm, stat, symlink} from 'node:fs/promises';
import {createServer} from 'node:net';
import {tmpdir} from 'node:os';
import {join} from 'node:path';
import {fileURLToPath} from 'node:url';

const php = process.env.SB_PHP || 'php8.2';
const repo = fileURLToPath(new URL('../', import.meta.url));
const root = await mkdtemp(join(tmpdir(),'sbshell-clip-cli-'));
const week = join(root,'42');
const recordHome = await mkdtemp(join(tmpdir(),'sbshell-record-home-'));
const secondRoot = await mkdtemp(join(tmpdir(),'sbshell-second-archive-'));
const database = join(recordHome,'catalog.sqlite3');
const environment = {...process.env,SB_PHP:php,SB_DATABASE:database};
let server;
function clip(args=[], cwd=week) {
  return spawnSync('bash',['-c','source "$1/lib/sb/clip.bash"; shift; sb.clip "$@"','sb.clip',repo,...args],
    {cwd,env:environment,encoding:'utf8'});
}
try {
  await mkdir(week); await mkdir(join(week,'sub')); await mkdir(join(root,'43'));
  await writeFile(join(week,'alpha one.md'),'# Alpha');
  await writeFile(join(week,'--flag.txt'),'literal filename');
  await writeFile(join(root,'43','other.txt'),'other week');
  await symlink(join(week,'alpha one.md'),join(week,'linked.md'));
  const portServer=createServer();
  await new Promise(resolve=>portServer.listen(0,'127.0.0.1',resolve));
  const port=portServer.address().port;
  await new Promise(resolve=>portServer.close(resolve));
  async function start(archive){
    server=spawn(php,['-S',`127.0.0.1:${port}`,'-t',archive,join(repo,'cruff/index.php')],{env:environment});
    let log='';
    await new Promise((resolve,reject)=>{
      const timeout=setTimeout(()=>reject(new Error('PHP did not start: '+log)),10000);
      server.stderr.on('data',chunk=>{log+=chunk;if(log.includes('started')){clearTimeout(timeout);resolve();}});
      server.on('error',error=>{clearTimeout(timeout);reject(error);});
      server.on('exit',code=>{clearTimeout(timeout);reject(new Error('PHP stopped: '+code+' '+log));});
    });
  }
  await start(root);
  const base=`http://127.0.0.1:${port}`;
  const request=(body,headers={})=>fetch(base+'/42/?sb-clipboard=1',{
    method:'POST',headers:{'Content-Type':'application/json',...headers},body:JSON.stringify(body)
  });
  let response=await fetch(base+'/42/');
  assert.equal(response.status,200);
  assert.ok((await response.text()).includes('id="sb-copy-selected"'));
  let listed=clip();
  assert.equal(listed.status,0); assert.equal(listed.stdout,''); assert.equal(listed.stderr,'');
  response=await request({files:['--flag.txt','alpha one.md','sub/','linked.md']});
  assert.equal(response.status,200); assert.deepEqual(await response.json(),{count:4});
  const expected=['--flag.txt','alpha one.md','sub/','linked.md'].map(name=>week+'/'+name+'\n').join('');
  listed=clip();
  assert.equal(listed.status,0); assert.equal(listed.stdout,expected); assert.equal(listed.stderr,'');
  // No argument or archive lookup: the same home database works from anywhere.
  assert.equal(clip([],tmpdir()).stdout,expected);
  assert.equal(clip([],repo).stdout,expected);
  const before=await stat(database);
  assert.equal(clip([],tmpdir()).stdout,expected);
  assert.equal((await stat(database)).mtimeMs,before.mtimeMs,'CLI reads must not modify SQLite.');
  response=await request({files:['missing.txt']});
  assert.equal(response.status,409); assert.equal(clip().stdout,expected);
  response=await request({files:['../43/other.txt']});
  assert.equal(response.status,400); assert.equal(clip().stdout,expected);
  response=await fetch(base+'/42/?sb-clipboard=1');
  assert.equal(response.status,405); assert.equal(response.headers.get('allow'),'POST');
  response=await request({files:['--flag.txt']},{'Content-Type':'text/plain'});
  assert.equal(response.status,415);
  response=await request({files:['--flag.txt']},{Origin:'https://unrelated.example'});
  assert.equal(response.status,403); assert.equal(clip().stdout,expected);
  response=await fetch(base+'/42/?sb-clipboard=1',{method:'POST',headers:{'Content-Type':'application/json'},body:'{'});
  assert.equal(response.status,400); assert.equal(clip().stdout,expected);
  response=await fetch(base+'/43/?sb-clipboard=1',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({files:['other.txt']})});
  assert.equal(response.status,200);
  const other=join(root,'43','other.txt')+'\n';
  assert.equal(clip([],tmpdir()).stdout,other,'Copying in another week replaces the global clipboard.');
  const piped=spawnSync('bash',['-c','source "$1/lib/sb/clip.bash"; sb.clip | while IFS= read -r file; do printf "[%s]\\n" "$file"; done','sb.clip',repo],{cwd:tmpdir(),env:environment,encoding:'utf8'});
  assert.equal(piped.status,0); assert.equal(piped.stdout,'['+other.trimEnd()+']\n');
  // Persistence and direct PHP/SQLite reading do not depend on a running server.
  await new Promise(resolve=>{server.once('exit',resolve);server.kill();}); server=null;
  assert.equal(clip().stdout,other);
  await writeFile(join(secondRoot,'second.txt'),'another archive');
  await start(secondRoot);
  response=await fetch(base+'/?sb-clipboard=1',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({files:['second.txt']})});
  assert.equal(response.status,200);
  assert.equal(clip([],week).stdout,join(secondRoot,'second.txt')+'\n','A server with a different archive root must use the same global list.');
  assert.equal(clip([],repo).stdout,join(secondRoot,'second.txt')+'\n');
  listed=clip([join(root,'missing')]);
  assert.notEqual(listed.status,0); assert.equal(listed.stdout,''); assert.ok(listed.stderr.trim());
  console.log('Global clipboard HTTP/CLI passed: shared home database, reads from unrelated working directories, ordered newline paths, spaces, symlinks, pipes, replacement, validation and stopped-server persistence.');
} finally { server?.kill(); await rm(root,{recursive:true,force:true}); await rm(secondRoot,{recursive:true,force:true}); await rm(recordHome,{recursive:true,force:true}); }
