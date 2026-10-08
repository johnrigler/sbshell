# SB Shell

SB Shell uses the filesystem itself as a publishing and documentation system for Mogwai.

Current GUI renderer: **v0.4.0**

The current model is:

- The repo contains the working filesystem.
- Files and directories are the source of truth.
- `files.txt` is the generated inventory.
- The GUI reads `files.txt` directly; content lists are not hand-maintained in `index.js`.
- A directory can reuse the shared `index.html` renderer through a symlink.
- The renderer searches the current directory and then parent directories for the nearest `files.txt`.
- Zero-padded ordinal filenames define ordering naturally.
- Optional metadata can be layered on separately without duplicating the directory inventory.
- Python/FileProxy are optional helpers, not requirements for reading the finished tree.

A simple inventory can be rebuilt from the directory being indexed:

```bash
find . -mindepth 1 ! -name files.txt | sort > ../files.tmp
mv ../files.tmp files.txt
```

Open the repository through any ordinary static HTTP server, for example:

```bash
python3 -m http.server 8000
```

See [MOGWAI.md](MOGWAI.md) for the architecture and [mogwai/SCAN-INGEST.md](mogwai/SCAN-INGEST.md) for scan filename/provenance rules.
