#!/bin/bash
BRANCH=$(git rev-parse --abbrev-ref HEAD)

if [ "$BRANCH" = "main" ]; then
    cp .env.main .env
    echo "Switched to main env (DB: songwriterlink)"
elif [ "$BRANCH" = "v2-dev" ]; then
    cp .env.v2 .env
    echo "Switched to v2-dev env (DB: songwriterlink_v2)"
else
    echo "Unknown branch '$BRANCH' — no env swap performed"
fi
