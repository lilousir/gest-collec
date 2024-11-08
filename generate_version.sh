#!/bin/bash

# Récupérer le dernier tag (par exemple, v1.0.0)
VERSION=$(git describe --tags --abbrev=0)
# Récupérer la branche actuelle (exemple : main ou develop)
BRANCH=$(git rev-parse --abbrev-ref HEAD)
# Récupérer l'ID du dernier commit (hash court du commit)
COMMIT=$(git rev-parse --short HEAD)
# Ajouter un horodatage pour savoir quand le fichier a été généré
TIMESTAMP=$(date +'%Y-%m-%d %H:%M:%S')

# Créer le fichier version.json avec les informations récupérées
echo "{ \"version\": \"$VERSION\", \"branch\": \"$BRANCH\", \"commit\": \"$COMMIT\", \"timestamp\": \"$TIMESTAMP\" }" > version.json