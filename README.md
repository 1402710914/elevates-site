# elevates-site

Elevates Pro marketing website (PHP + static assets).

## Local setup (XAMPP)

1. Clone into `htdocs/elevate1` (or your web root).
2. Copy config files:
   ```bash
   cp db.example.php db.php
   cp google_sheet_config.example.php google_sheet_config.php
   ```
3. Edit `db.php` with local MySQL credentials.
4. Import/create the `elevate` database and required tables.
5. Add large video files manually (not in Git):
   - `video.mp4`
   - `landiing-page-video/landing-video.mp4`
6. Open `http://localhost/elevate1/`

## Server deploy (Git pull)

Code updates via Git. **Config files and videos stay on the server** — they are not overwritten by `git pull`.

### First time on server (already has manual code)

```bash
cd /path/to/your/public_html   # or site root

# 1. Backup secrets & media
cp db.php /tmp/db.php.bak
cp google_sheet_config.php /tmp/google_sheet_config.php.bak 2>/dev/null || true

# 2. Init Git in existing folder (or clone fresh to a temp dir and merge)
git init
git remote add origin https://github.com/1402710914/elevates-site.git
git fetch origin
git checkout -b main
git reset --hard origin/main

# 3. Restore server-only files
cp /tmp/db.php.bak db.php
cp /tmp/google_sheet_config.php.bak google_sheet_config.php 2>/dev/null || cp google_sheet_config.example.php google_sheet_config.php

# 4. Ensure videos/uploads still exist on server
```

**Safer alternative:** clone to a new folder, copy `db.php`, `google_sheet_config.php`, `uploads/`, and `*.mp4` from old folder, then point the domain to the new folder.

### Every update after that

```bash
cd /path/to/your/public_html
git pull origin main
```

No need to re-upload PHP/HTML/CSS — only pull. Database and `db.php` are unchanged.

## What is NOT in Git

| Item | Reason |
|------|--------|
| `db.php` | Server credentials |
| `google_sheet_config.php` | API secret |
| `*.mp4` | Too large for GitHub |
| `old/` | Backup folder |
| `uploads/*` | User-uploaded content |
