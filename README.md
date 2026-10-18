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

## Public annual Daisy archives and local PHP

SB Shell will maintain each public `daisy_YYYY` archive beyond its ISO week/day
structure. Mogwai owns the reusable year starter and tool references. The user reports the local PHP assembler running. See
[the October 18 direction and PHP sources](notes/2026-10-18-public-daisy-and-local-php.md).

## Current navigation convention (October 12, 2026)

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
