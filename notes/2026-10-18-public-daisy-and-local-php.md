# Public Daisy archives and local PHP (2026-10-18)

Annual daisy_YYYY repositories are intended to be public. CertLedger becomes
public after private material is removed, including review of retained Git
history. Private working documents stay outside public archives.

Mogwai holds the [annual starter](https://github.com/johnrigler/mogwai/tree/main/templates/daisy-year)
and references to SB Stats, FileProxy, crypto-python, Chisel and other writers.
Daisy owns its ISO WWD/ date structure. SB Shell maintains each archive beyond
that coordinate: selected units, numbered fragments, images, symlinks,
navigation and long printable pages. Root files.txt remains the current
root-relative inventory; preserve ALP's separate .files.txt convention.

## PHP on the laptop

The user has PHP installed. Inspect the local configuration:

~~~bash
php -r 'phpinfo();'
~~~

Serve the current static SB Shell through PHP:

~~~bash
php -S 127.0.0.1:8000 -t "$HOME/sbshell"
~~~

Open http://127.0.0.1:8000/myshell/ for the existing static view.

The historical assemblers are modules/php/index.php and cruff/sb_shell.php.
They contain legacy short tags/unquoted array keys and assumptions about
accompanying files. This note identifies the revival starting point; the
old assemblers have not been modernized or tested on current PHP here.

Next: select an annual Daisy checkout, assemble its ordered units in PHP,
and export HTML plus assets for static hosting/IPFS. PHP executes locally;
GitHub Pages serves the export. Chrome handles US Letter printing.
