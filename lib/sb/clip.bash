sb.clip() {
    local sb_php=${SB_PHP:-php8.2}
    if [[ -z ${SB_PHP:-} ]] && ! command -v "$sb_php" >/dev/null; then sb_php=php; fi
    "$sb_php" "${BASH_SOURCE[0]%/*}/../../cruff/clipboard.php" "$@"
}
