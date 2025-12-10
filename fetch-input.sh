#!/bin/bash

set -euo pipefail

show_help() {
    echo "Usage:"
    echo "  $0 <day|dayXX|XX> <SESSION_TOKEN>"
    echo
    echo "Examples:"
    echo "  $0 5 <token>         # Fetches day 5 input"
    echo "  $0 05 <token>"
    echo "  $0 day05 <token>"
    echo
    echo "Input will be saved to:"
    echo "  ./src/DayXX/input.txt"
}

# Require arguments or show help
if [[ $# -lt 2 ]]; then
    show_help
    exit 1
fi

day="${1:-}"
session="${2:-}"

# Validate session token
if [[ -z "$session" ]]; then
    echo "Error: SESSION_TOKEN cannot be empty." >&2
    exit 1
fi

# Parse day argument (supports: 5, 05, day05, day5, day0005)
if [[ "$day" =~ ^day([0-9]+)$ ]]; then
    day_number="${BASH_REMATCH[1]}"
else
    day_number="$(echo "$day" | sed 's/^day//; s/^0*//')"
fi

if [[ -z "$day_number" ]]; then
    echo "Error: Could not parse day number from '$day'." >&2
    exit 1
fi

# DayXX formatting
day_number_padded=$(printf '%02d' "$day_number")
output_dir="./src/Day${day_number_padded}"
output_file="${output_dir}/input.txt"

url="https://adventofcode.com/2025/day/$day_number/input"

mkdir -p "$output_dir"

echo "Fetching input for day $day_number_padded..."
curl -sS --fail --cookie "session=$session" "$url" -o "$output_file"

echo "Saved to: $output_file"
echo "Done."