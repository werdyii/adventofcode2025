#!/bin/bash

set -euo pipefail

RED="\033[01;31m"
GREEN="\033[1;32m"
YELLOW="\033[1;33m"
NO_COLOUR="\033[0m"

show_help() {
  echo -e "${YELLOW}Usage:${NO_COLOUR}"
  echo "  $0 <day|dayXX|XX> <SESSION_TOKEN>"
  echo
  echo "Examples:"
  echo "  $0 5 <token>"
  echo "  $0 05 <token>"
  echo "  $0 day05 <token>"
  echo
  echo "This will:"
  echo "  • Scaffold src/DayXX"
  echo "  • Create tests/DayXXTest.php"
  echo "  • Fetch AoC input → src/DayXX/input.txt"
}

# Validate args
if [[ $# -lt 2 ]]; then
  show_help
  exit 1
fi

day_raw="$1"
session="$2"

# Extract numeric part from argument
if [[ "$day_raw" =~ ^day([0-9]+)$ ]]; then
    day_number="${BASH_REMATCH[1]}"
else
    day_number="$(echo "$day_raw" | sed 's/^day//; s/^0*//')"
fi

if [[ -z "$day_number" ]]; then
  echo -e "${RED}Could not parse day number from '$day_raw'.${NO_COLOUR}"
  exit 1
fi

day=$(printf '%02d' "$day_number")
day_dir="./src/Day${day}"
test_file="./tests/Day${day}Test.php"
input_file="${day_dir}/input.txt"

# Check if scaffolding already exists
if [[ -f "$test_file" || -d "$day_dir" ]]; then
  echo -e "${RED}This day has already been scaffolded (Day${day}).${NO_COLOUR}"
  exit 1
fi

echo -e "${YELLOW}Scaffolding Day${day}...${NO_COLOUR}"

# Create directory structure
cp -r ./template/DayX "$day_dir"

# Replace template identifiers
sed -i "s/DayX/Day${day}/g" "${day_dir}/Puzzle1.php"
sed -i "s/DayX/Day${day}/g" "${day_dir}/Puzzle2.php"

# Create test file
cp ./template/DayXTest.php "$test_file"
sed -i "s/DayX/Day${day}/g" "$test_file"

# Fetch AoC input
url="https://adventofcode.com/2025/day/${day_number}/input"

echo -e "${YELLOW}Fetching AoC input for Day ${day}...${NO_COLOUR}"
mkdir -p "$day_dir"

# Fail on HTML error (invalid token)
response=$(curl -sS --fail --cookie "session=${session}" "$url" || true)

if [[ "$response" == *"<"*"html"* ]]; then
  echo -e "${RED}Failed to fetch input – likely an invalid session token.${NO_COLOUR}"
  exit 1
fi

echo "$response" > "$input_file"

echo -e "${GREEN}Day ${day} scaffolded successfully. Input saved to ${input_file}.${NO_COLOUR}"
echo -e "${YELLOW}Happy coding!${NO_COLOUR}"