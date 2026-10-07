# SB Shell

SB Shell started as a Bash/PHP environment for using the filesystem itself as a publishing and documentation system.

The current revival is part of Mogwai:

- Bash and vi remain the authoring environment.
- The repo currently contains the working filesystem.
- Files and directories remain the source of truth.
- Zero-padded ordinal filenames define page/position/nesting.
- Each browsable directory can carry a checked-in `index.js` manifest.
- A shared static renderer displays HTML, scans/images, and other files.
- Python/FileProxy are optional helpers, not requirements for reading the finished tree.
- Scanner, fax, Gemini/LLM output, Daisy, signed feeds, and IPFS can all enter the same filesystem pipeline.

Open the repository through any ordinary static HTTP server. For example:

```bash
python3 -m http.server 8000
```

Then browse the directory containing the repo.

The older Mogwai Python service under `mogwai/` is still available for API experiments, but static directory manifests are now the durable representation.

See [MOGWAI.md](MOGWAI.md) for the architecture and [mogwai/SCAN-INGEST.md](mogwai/SCAN-INGEST.md) for scan filename/provenance rules.
