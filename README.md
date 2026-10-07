# SB Shell

SB Shell started as a Bash/PHP environment for using the filesystem itself as a publishing and documentation system.

The current revival keeps the original model but moves the browser-facing layer toward Mogwai:

- Bash and vi remain the authoring environment.
- Files and directories remain the source of truth.
- Zero-padded ordinal filenames define page/position/nesting.
- A tiny Python service describes the local tree.
- Vanilla JavaScript renders it in the browser.
- FileProxy, ALP, Daisy, signed feeds, and IPFS can be layered on later.

See [MOGWAI.md](MOGWAI.md) for the architecture.

## Quick start

From the directory you want Mogwai to browse:

```bash
python3 /path/to/sbshell/mogwai/server.py .
```

Then open:

```
http://127.0.0.1:8765/
```

The first implementation is intentionally read-only. Editing remains where SB Shell began: Bash and vi.



RESPONSE


I added a "now"directory and something from gemini, this stuff needs to get processd into 
sbshell like webpages.
