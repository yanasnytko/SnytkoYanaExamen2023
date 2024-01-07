# Examen 2023 par Yana Snytko

## Installation

### Prérequis
- PHP 
- Composer
- Symfony CLI 

### Instructions
1. Clonez le dépôt : `git clone https://github.com/yanasnytko/SnytkoYanaExamen2023.git`
2. Installez les dépendances : `composer install`
3. Configurez votre environnement (si nécessaire).
4. Lancez le serveur de développement : `symfony server:start` (pour les projets Symfony) ou utilisez votre serveur web préféré.

### Base de données

N'oubliez pas de créer la base de données :
1. Créez la DB : `php bin/console doctrine:database:create`
2. Créez les tables : `php bin/console doctrine:migrations:migrate`