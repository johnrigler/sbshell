# SB Shell → Mogwai

SB Shell is being revived as a local-first publishing/workbench layer for Mogwai.

The core rule stays Unix-simple:

- Bash and vi are first-class authoring tools.
- The filesystem is the document model.
- File and directory names carry order and structure.
- A browser renders the local tree through a very small Python service.
- IPFS publication is a later projection of the local tree, not the editing environment.

## Ordinal filenames

Content files use underscore-delimited ordinal fields followed by an optional label:

```
1_01_intro.md
1_02_argument.md
1_02_01_example.md
1_03_graph.md
```

Zero padding is deliberate. It allows ordinary lexical ordering from `ls`, shell globs, Python, and JavaScript to agree without special numeric sorting.

Interpretation:

```
1_02_01_example.md
│ │  │  └─ label
│ │  └──── nested ordinal
│ └─────── position
└───────── page
```

The number of ordinal fields is open-ended. Mogwai consumes leading numeric underscore-separated fields as coordinates. Remaining text is metadata/label.

The filename is therefore both an address and a lightweight ordered tree.

## Local architecture

```
Bash / vi
    ↓
files + directories
    ↓
Python local service
    ↓
JSON filesystem description
    ↓
Vanilla JavaScript renderer
    ↓
browser / optional extension
```

The first implementation lives under `mogwai/`.

Start it from any directory you want to browse:

```bash
python3 /path/to/sbshell/mogwai/server.py .
```

Then open:

```
http://127.0.0.1:8765/
```

## Direction

Future pieces can add:

- save/write endpoints compatible with FileProxy
- directory watching
- Markdown and structured-data renderers
- graph modules such as the old SB Stats idea
- ALP/Daisy conventions
- signed feed manifests
- IPFS publication
- Mogwai identity/access rules

The local filesystem remains authoritative. Databases and network services are optional indexes or projections, not the source of truth.
