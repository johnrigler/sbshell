# SB Shell

Filesystem-first publishing with a local PHP assembler and a static browser
path. Files, names, directories and symlinks supply the document structure.
Bash and vi remain first-class authoring tools; Python and FileProxy are optional.

## Working standards

[STANDARDS.md](STANDARDS.md) records John's direct PHP/shell style and the
mechanisms visible in the current source. [AGENTS.md](AGENTS.md) applies those
standards to assistant changes. The PHP work is in [cruff/index.php](cruff/index.php)
with nested index.php symlinks reusing the same renderer. John reports this
PHP path running locally; commit 5344787 records the October 18 revival.

The PHP assembler reads its directory. The static inventory conventions below
describe the separate static browser path.

## Directory navigation in PHP

Start PHP in the directory you want to browse, with the assembler as its router:

```bash
cd /home/john/daisy_2026
php8.2 -S 127.0.0.1:39692 -t . /home/john/sbshell/cruff/index.php
```

Open `http://127.0.0.1:39692/`. A directory without `1_*.*` parts shows an
unordered list of its directories and files. Click down through `42/` to
`firmus-ncs/`, for example. Each assembled page has breadcrumbs back to the
directory where you started PHP. Directories with numbered parts assemble
them as before, with their directory list available under **Files and directories**.
The list starts open when there are no numbered parts, and closed when there are.

Breadcrumbs, the directory list and the refresh checkbox are automatically
hidden when printing. Dotfiles and the shared index itself are omitted from
the list. Existing files still use PHP's normal serving behavior, including
relative CSS, JavaScript, images and PDFs. Directory URLs get a trailing slash
so those relative links keep working.

Using the [PHP built-in server's router](https://www.php.net/commandline.webserver)
means child directories need no index.php copies or inventory file. Existing
index.php symlinks also keep using the requested directory, rather than the
directory holding the shared renderer source.

## Script logs in PHP

The current `cruff/index.php` loop assembles `1_*.*` in directory order.
PHP parts still use `include`; `.ts`, `.unixTs` and `.script` recordings use
[cruff/script.php](cruff/script.php). Here `.ts` means a Unix `script` log.
Prefer **`.unixTs`** for new recordings, matching Daisy's `d.script` filenames;
existing `.ts` files, including `cruff/1_05.ts`, keep working without renaming.

The viewer comes from `daisy_2026/42/sbshell-script-viewer.html`. Terminal mode
preserves ANSI colors and basic cursor editing. Sections mode groups `-->>`
commands and turns `-->> #` comments into annotations. Previous, Next and
Show all step through blocks. Complete alternate-screen sessions, such as Vim,
become boundary markers; their original recording stays intact.

The PHP include embeds the recording and viewer in the assembled HTML, so a
saved page needs no transcript fetch or external library. Transcript text is
displayed literally, including any captured HTML or PHP source. Each recording
has its own controls. The HTML viewer uses a larger 16px monospace font in
an 80-column panel; narrow screens scroll horizontally. Chrome printing uses
9pt type and compact padding to fit an 80-column listing on US Letter with
one-inch margins. Longer metadata or older, wider output can still wrap.
Use **Auto-refresh every 10 seconds** at the top of the PHP page to
pause or resume updates. Refresh starts on and remembers your choice for that
page in this browser.

Capture new recordings at 80 columns:

```bash
source ./lib/d.script.bash
d.script
```

`d.script` sets the terminal width before starting `script`, so both the
recording header and commands such as `ls` use 80 columns. Leaving the recording
restores the previous terminal width. The timestamped `.unixTs` naming stays
the same; use the usual numbered part name to place a recording in the page.
Already recorded output, including `1_05.ts`, keeps its original layout.

From the repository root:

```bash
php8.2 -S localhost:8000 -t .
```

Open `http://localhost:8000/cruff/` to read the sample. The nested index.php
symlinks use the same include while continuing to read their own directories.

## Public annual Daisy archives and local PHP

SB Shell will maintain each public `daisy_YYYY` archive beyond its ISO week/day
structure. Mogwai owns the reusable year starter and tool references. The user reports the local PHP assembler running. See
[the October 18 direction and PHP sources](notes/2026-10-18-public-daisy-and-local-php.md).

## Static navigation convention (October 12, 2026)

**The inventory is at the repository root: `files.txt`.** The entries are qualified paths relative to that root, for example:

```text
myshell/1_01-gemini-balloon.html
myshell/1_02.html
myshell/live.png
```

Do **not** put this same inventory inside `myshell/files.txt`. The renderer searches from its current directory upward for an inventory and interprets listed paths relative to the location where it found the inventory. A `myshell/files.txt` containing `myshell/...` makes an extra nested `myshell` appear.

`child.html` and `myshell/index.html` contain the renderer code. It builds its listing from the inventory, not from the older `index.js` manifests. `index.js` is legacy metadata, not the current navigation source. The files `index.html`, `index.js`, and `files.txt` are treated as infrastructure.

The root `files.txt` covers the `myshell` tree. To include other trees, add their qualified relative paths too. Empty directories may not appear in navigation if nothing inside them is indexed.

## Rebuild from Bash

From the **repository root** (the directory containing `myshell/`):

```bash
find myshell -mindepth 1 \
    -name '.*' -prune -o \
    -name 'files.txt' -prune -o \
    -name '.files.txt' -prune -o \
    -print | LC_ALL=C sort > files.txt
```

This includes normal files and subdirectories below `myshell/` but skips hidden files and directories. The committed `sb.find-43742.1` Bash function performs this operation (its optional argument is a repository-root path, not the `myshell` directory). If your interactive shell already has an older `sb.find` definition loaded, source the updated function again.

```bash
source ./sb.find-43742.1
sb.find
git diff -- files.txt
git add files.txt
git commit -m "Refresh SB Shell inventory"
git push
```

Note that a Bash function loaded into your terminal does not automatically change when its file changes in Git; you must source it again. Do not run the function from inside `myshell` unless you supply the correct repository root.

## Serving and checking

From the repository root:

```bash
python3 -m http.server 8000
```

Visit `http://localhost:8000/myshell/`. You should see `1_01-gemini-balloon.html`, `1_02.html` and the other children directly, **not** another `myshell` entry. If an extra `myshell` appears, check for a leftover `myshell/files.txt` or another nearer inventory. If the page reports no inventory, ensure the root `files.txt` is being served successfully.

## Hidden inventory filename

A `.files.txt` variant is **not the canonical repository layout yet**. One copy of the shared renderer has been changed to probe `.files.txt` first, then fall back to `files.txt`, but `myshell/index.html` still follows the existing `files.txt` behavior. The current working convention remains root `files.txt`. A future migration must update both renderer copies and the Bash generator together. A dotfile is not private and can still be served publicly.

See [MOGWAI.md](MOGWAI.md) for architecture and [mogwai/SCAN-INGEST.md](mogwai/SCAN-INGEST.md) for scan naming.

## Project Jupiter: first CertLedger-style publication page

[`myshell/1_03-project-jupiter.html`](myshell/1_03-project-jupiter.html) is a
static, self-contained, US Letter-printable dated dossier with YouTube video,
evidence links, two New Mexico Supreme Court docket IDs, a timeline, and
explicit missing-document/telemetry statuses. It is listed in the **root**
`files.txt`, respecting the working navigation convention. It is a public
editorial derivative of the annual
[`daisy_2026/421`](https://github.com/johnrigler/daisy_2026/tree/main/421)
record, not a live private-repo synchronization. Material changes need a
reviewed new publication snapshot.
