# Projet programmation Web

## NFA021

## Un site de critiques photos et concours en ligne

## Auteur : Stéphane DAUGUET

### Besoin/Objectifs

Ce site sera ouvert à tout public et ciblera les amateurs et passionnés de photo.
Il proposera à l’internaute de déposer une photo qui sera soumise aux critiques des personnes inscrites.
Ces critiques seront exprimées sous la forme d’un système de notation, établi selon certains critères (composition, technique, symbolique, couleur ou noir et blanc, etc.) plus une note globale. Une zone de commentaire libre sera également prévue pour donner son impression et rédiger une critique « constructive ». Deux zones (le +, et le -), pourront être proposées.
Des thèmes/rubriques seront proposés lors du dépôt de la photo (Noir et blanc, paysage…).
Le site organisera également des concours photos selon des thèmes prédéfinis (ex, un thème par mois).
Une photo pourra être proposée à la critique et au concours simultanément.
Le site sera développé en PHP avec une base de données MySql.

### Fonctionnalités du site

Un formulaire d’inscription sera la première étape avant de pouvoir déposer ses photos ou de rédiger une critique.
Le formulaire contiendra les champs usuels (Pseudo, prénom, ville, petit commentaire de présentation…), et un mot de passe devra être renseigné pour permettre l’authentification lors des prochaines visites.

Une page sera dédiée au dépôt d’une photo :
elle comportera un formulaire de téléchargement de fichiers plus des zones de saisie réservées à la description de la photo (thème, lieu, date, commentaire libre).
Cette page sera également utilisée pour proposer une photo à un concours existant.

Une galerie où les photos déposées seront visibles et accessibles.
Cette galerie pourra être filtrée par thème, elle sera ouverte aux inscrits et non-inscrits.
Un clic sur la photo permettra aux inscrits de déposer une critique.

Une page sera réservée à la critique.
Elle affichera la photo en grand format, puis des zones de liste seront utilisées pour la notation (une zone par critère, plus une note globale).
Un champ de commentaire libre permettra de rédiger une critique.

Une page sera dédiée aux concours.
Concours actif, anciens concours avec accès à la galerie de chacun et les résultats.

Une page pour chaque inscrit (avec ses photos déposées, critique émise).
