# SB Shell

SB Shell is a filesystem-first publishing and documentation workbench for Mogwai. Files and directory names carry the content, hierarchy, and ordering. Bash and vi are valid authoring tools. A static HTTP server is enough to read a published tree; Python and FileProxy are optional tools.

## Current implementation (renderer v0.4.0)

**As verified on master on 2026-10-12, the inventory filename is `files.txt`, not `.files.txt`.** Do not rename it without changing the renderer in `child.html`.

- `child.html` implements the shared browser renderer. `myshell/index.html` currently contains the same renderer as an ordinary HTML file (even though some documentation describes symlinks).
- On load, the renderer fetches `files.txt` from the current directory; if absent, it walks upward through parent directories (up to 12 levels).
- Once it finds an inventory, each entry is interpreted **relative to the directory containing that inventory**.
- `index.js` still exists in places, but renderer v0.4.0 **does not read it** to build the tree. Do not maintain both lists manually.
- The renderer hides `index.html`, `index.js`, and `files.txt` from its navigation; other files, including unexpected hidden files listed in the inventory, may appear.
- HTML entries open in an iframe, image entries in an image element, and other files in an iframe.
- Filenames with zero-padded ordinals, such as `1_01_intro.html`, sort naturally.
- The repository contents are the source of truth. IPFS or another static host can publish the generated tree.

## Rebuilding an inventory

**Working from within the directory to be indexed:**

```bash
cd myshell
find . -mindepth 1 -name '.*' -prune -o -name files.txt -prune -o -print | LC_ALL=C sort > files.txt
```

This writes paths like `./1_01-gemini-balloon.html`, which the renderer normalizes. It skips hidden files/directories, including `.git`, and excludes the generated inventory. It includes nested paths if they exist.

A reusable Bash function for an interactive shell (or a sourced Bash functions file):

```bash
sb.find ()
{
    local dir="${1:-.}"
    (
        cd "$dir" || return 1
        find . -mindepth 1 \
            -name '.*' -prune -o \
            -name files.txt -prune -o \
            -print | LC_ALL=C sort > files.txt
        printf 'Indexed %s: %s entries\n' "$PWD" "$(wc -l < files.txt)"
    )
}
```

Use `sb.find` inside `myshell`, or `sb.find myshell` from the repository root. An existing checked-in function named `sb.find-43742.1` currently hardcodes `find myshell ... > myshell/files.txt`; it is dependent on the current directory and writes `myshell/` prefixes into the inventory. Replace the sourced function locally when switching to the version above.

**Do not mix path conventions.** With an inventory at `myshell/files.txt`, listing `myshell/1_01.html` is wrong: the renderer treats it as a child named `myshell`, and clicking it can resolve to `myshell/myshell/`. Use `./1_01.html` or `1_01.html` instead.

If you want one inventory for a full subtree, generate it at the **subtree root**, and make its entries relative to that location. For example, a repository-root inventory may legitimately contain `myshell/1_01.html`.

## Publishing and verification

From the repository root:

```bash
python3 -m http.server 8000
```

Then visit `http://localhost:8000/myshell/`. The HTML files should appear directly, with no spurious `myshell/` directory nested inside `myshell/`.

After changing files, regenerate the appropriate inventory, review `git diff -- myshell/files.txt`, commit, and push. Changes to the working filesystem are not automatically reflected in a committed inventory.

If the page says `No files in this directory`, verify that the inventory exists at the current or an ancestor directory and that the listed paths are relative to **that** location. If it says `No files.txt found here or in a parent directory`, check the filename, hosting path, and HTTP response. Browsers cannot assume filesystem directory listing APIs.

## Potential migration to hidden `.files.txt`

The name `.files.txt` is **not** supported by the current renderer. To adopt it, make one coordinated change:

1. Change `child.html` (and any copied renderer, including `myshell/index.html`) to fetch `.files.txt`, update its user-facing error/status text, and exclude `.files.txt` as infrastructure.
2. Change the Bash inventory generator to write `.files.txt` and explicitly exclude its own output.
3. Rename or regenerate all inventories consistently, deploy the renderer and inventories together, and verify nested navigation.
4. Confirm your HTTP server and IPFS packaging actually serve dotfiles; hiding a filename in a directory listing does **not** make its contents private.

The example Bash command above documents **the current `files.txt` format**, not the proposed hidden-file format.

See [MOGWAI.md](MOGWAI.md) for background, and [mogwai/SCAN-INGEST.md](mogwai/SCAN-INGEST.md) for scanner filename conventions.
