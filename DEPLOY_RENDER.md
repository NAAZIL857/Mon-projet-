# Déploiement sur Render

## Étapes pour déployer votre boutique sur Render

### 1. Pousser les fichiers sur GitHub
```bash
git add .
git commit -m "Configuration pour Render"
git push origin main
```

### 2. Créer un compte sur Render
- Allez sur https://render.com
- Inscrivez-vous avec votre compte GitHub

### 3. Créer un nouveau Web Service
1. Cliquez sur "New +" → "Web Service"
2. Connectez votre dépôt GitHub: `NAAZIL857/Mon-projet-`
3. Configurez le service:
   - **Name**: gabonshop
   - **Environment**: Docker
   - **Plan**: Free

### 4. Variables d'environnement (déjà configurées dans render.yaml)
- `DB_HOST`: mysql-nanziibrahim.alwaysdata.net
- `DB_NAME`: nanziibrahim_gabonshop
- `DB_USER`: 441098
- `DB_PASS`: Nanzibac2k23

### 5. Déployer
- Cliquez sur "Create Web Service"
- Render va automatiquement déployer votre application
- Attendez 5-10 minutes pour le premier déploiement

### 6. Accéder à votre site
Votre site sera accessible à: `https://gabonshop.onrender.com`

## Architecture
- **Frontend/Backend**: Hébergé sur Render (gratuit)
- **Base de données**: Hébergée sur AlwaysData
- **Code source**: GitHub

## Notes importantes
- Le plan gratuit de Render met l'application en veille après 15 minutes d'inactivité
- Le premier chargement après la mise en veille peut prendre 30-60 secondes
- La base de données AlwaysData reste toujours active
