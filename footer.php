    <!-- Fermeture du conteneur principal "main" ouvert plus haut dans la page. -->
    </main>
    <!-- Début du pied de page avec des classes et un identifiant pour le ciblage CSS/JS. -->
    <footer class="site-footer border-top py-5" id="Contact">
        <!-- Conteneur Bootstrap pour centrer et limiter la largeur du contenu. -->
        <div class="container">
            <!-- Ligne Bootstrap pour organiser les colonnes du pied de page. -->
            <div class="row gy-4 align-items-start">
                <!-- Colonne gauche en largeur 5 sur grand écran. -->
                <div class="col-lg-5">
                    <!-- Lien bouton vers la page contact en utilisant ROOT_URL en PHP. -->
                    <a class="btn-contact-footer" href="<?php echo ROOT_URL . '/contact.php'; ?>">Contactez-nous :</a>
                    <!-- Paragraphe avec une marge basse réduite. -->
                    <p class="mb-1">
                        <!-- Lien mailto pour ouvrir un email prérempli. -->
                        <a href="mailto:secretariat@bec-bordeaux?subject=Demande%20de%20contact%20depuis%20le%20site%20BEC%20Bordeaux">
                            <!-- Texte affiché de l'adresse email. -->
                            secretariat@bec-bordeaux
                        <!-- Fermeture du lien mailto. -->
                        </a>
                    <!-- Fermeture du paragraphe. -->
                    </p>
                    <!-- Paragraphe contenant deux liens téléphoniques avec un saut de ligne. -->
                    <p class="mb-3"><a href="tel:+33671942380">Tel : 06 71 94 23 80</a><br>
                    <!-- Lien tel vers un numéro de téléphone fixe. -->
                    <a href="tel:+33556918350">Tel : 05 56 91 83 50</a> </p>
                    <!-- Conteneur flex pour aligner les icônes de réseaux sociaux. -->
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <!-- Lien vers la page Instagram avec une classe d'icône sociale. -->
                        <a href="https://www.instagram.com/becbasket/?hl=fr" class="social-icon">
                            <!-- Image de l'icône Instagram avec une URL construite via ROOT_URL. -->
                            <img src="<?php echo ROOT_URL . '/src/images/logo/logo-reseaux-sociaux/instagram.png'; ?>" alt="Instagram">
                        <!-- Fermeture du lien Instagram. -->
                        </a>
                        <!-- Lien vers la page Facebook avec une classe d'icône sociale. -->
                        <a href="https://www.facebook.com/becofficiel/?locale=fr_FR" class="social-icon">
                            <!-- Image de l'icône Facebook avec une URL construite via ROOT_URL. -->
                            <img src="<?php echo ROOT_URL . '/src/images/logo/logo-reseaux-sociaux/facebook.png'; ?>" alt="Facebook">
                        <!-- Fermeture du lien Facebook. -->
                        </a>
                    <!-- Fermeture du conteneur d'icônes. -->
                    </div>
                <!-- Fermeture de la colonne gauche. -->
                </div>

                <!-- Colonne droite en largeur 4 sur grand écran. -->
                <div class="col-lg-4">
                    <!-- Conteneur ratio pour garder un format 4x3 avec bords arrondis. -->
                    <div class="ratio ratio-4x3 rounded-4 overflow-hidden shadow-sm">
                        <!-- Iframe Google Maps pour afficher l'adresse. -->
                        <iframe
                            <!-- URL d'intégration Google Maps avec paramètres. -->
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387.73473039224695!2d-0.5620506434721906!3d44.827972032339!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd55264b1f8d16e7%3A0x60bae14b3c5cbd38!2s8%20Cr%20Barbey%2C%2033800%20Bordeaux!5e0!3m2!1sfr!2sfr!4v1770375688862!5m2!1sfr!2sfr""
                            <!-- Style inline pour supprimer la bordure par défaut. -->
                            style="border:0;"
                            <!-- Autorisation du plein écran pour la carte. -->
                            allowfullscreen=""
                            <!-- Chargement différé de l'iframe. -->
                            loading="lazy"
                            <!-- Politique de référent pour l'iframe. -->
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <!-- Fermeture du conteneur ratio. -->
                    </div>
                <!-- Fermeture de la colonne droite. -->
                </div>
            <!-- Fermeture de la ligne principale. -->
            </div>
            <!-- Nouvelle ligne pour les liens légaux. -->
            <div class="row mt-4">
                <!-- Colonne pleine largeur et texte centré. -->
                <div class="col-12 text-center">
                    <!-- Paragraphe en petit texte italique sans marge basse. -->
                    <p class="small fst-italic mb-0">
                        <!-- Lien vers les CGU avec ROOT_URL. -->
                        <a href="<?php echo ROOT_URL . '/infoleg/cgu.php'; ?>">Conditions d’utilisation</a>
                        <!-- Séparateur visuel entre les liens. -->
                        -
                        <!-- Lien vers les mentions légales avec ROOT_URL. -->
                        <a href="<?php echo ROOT_URL . '/infoleg/mentionleg.php'; ?>">Mentions légales</a>
                        <!-- Séparateur visuel entre les liens. -->
                        -
                        <!-- Lien vers la page RGPD avec ROOT_URL. -->
                        <a href="<?php echo ROOT_URL . '/infoleg/rgpd.php'; ?>">RGPD</a>
                    <!-- Fermeture du paragraphe. -->
                    </p>
                <!-- Fermeture de la colonne. -->
                </div>
            <!-- Fermeture de la ligne. -->
            </div>
        <!-- Fermeture du conteneur principal. -->
        </div>
    <!-- Fermeture du footer. -->
    </footer>
    <!-- Début du script pour gérer les sous-menus de l'en-tête. -->
    <script>
        // Sélectionne tous les éléments avec la classe .header-submenu.
        document.querySelectorAll('.header-submenu').forEach((submenu) => {
            // Récupère le bouton/élément de bascule dans ce sous-menu.
            const toggle = submenu.querySelector('.submenu-toggle');
            // Définit une fonction pour fermer le sous-menu.
            const closeSubmenu = () => {
                // Retire la classe qui indique l'ouverture.
                submenu.classList.remove('is-open');
                // Vérifie que le bouton de bascule existe.
                if (toggle) {
                    // Met l'attribut aria-expanded à false pour l'accessibilité.
                    toggle.setAttribute('aria-expanded', 'false');
                }
            };

            // Si aucun bouton de bascule, on sort de la boucle pour ce sous-menu.
            if (!toggle) {
                return;
            }

            // Ajoute un écouteur de clic sur le bouton de bascule.
            toggle.addEventListener('click', (event) => {
                // Empêche le comportement par défaut du lien/bouton.
                event.preventDefault();
                // Vérifie si le sous-menu est déjà ouvert.
                const isOpen = submenu.classList.contains('is-open');

                // Ferme tous les autres sous-menus ouverts.
                document.querySelectorAll('.header-submenu.is-open').forEach((openSubmenu) => {
                    // Ne ferme pas le sous-menu actuel.
                    if (openSubmenu !== submenu) {
                        // Récupère le bouton de bascule du sous-menu ouvert.
                        const openToggle = openSubmenu.querySelector('.submenu-toggle');
                        // Retire la classe d'ouverture.
                        openSubmenu.classList.remove('is-open');
                        // Met à jour aria-expanded si le bouton existe.
                        if (openToggle) {
                            openToggle.setAttribute('aria-expanded', 'false');
                        }
                    }
                });

                // Si le sous-menu est ouvert, on le ferme.
                if (isOpen) {
                    closeSubmenu();
                } else {
                    // Sinon on l'ouvre.
                    submenu.classList.add('is-open');
                    // Met aria-expanded à true pour l'accessibilité.
                    toggle.setAttribute('aria-expanded', 'true');
                }
            });

            // Ferme le sous-menu si on clique en dehors.
            document.addEventListener('click', (event) => {
                // Vérifie si la cible du clic n'est pas dans le sous-menu.
                if (!submenu.contains(event.target)) {
                    closeSubmenu();
                }
            });

            // Ferme le sous-menu avec la touche Échap.
            document.addEventListener('keydown', (event) => {
                // Vérifie si la touche pressée est Escape.
                if (event.key === 'Escape') {
                    closeSubmenu();
                }
            });
        });
    </script>
    <!-- Début du script pour l'effet de survol des boutons. -->
    <script>
        // Sélectionne tous les boutons et éléments assimilés pour l'effet.
        const buttonHoverTargets = document.querySelectorAll(
            // Sélecteur CSS combiné pour différents types de boutons.
            'button:not(.btn-check), input[type="button"], input[type="submit"], input[type="reset"], .btn, .btn-contact-footer, .btn-more, .btn_envoyer, .bouton'
        );

        // Parcourt chaque bouton trouvé.
        buttonHoverTargets.forEach((button) => {
            // Ignore les boutons désactivés.
            if (
                button.disabled ||
                button.classList.contains('disabled') ||
                button.getAttribute('aria-disabled') === 'true'
            ) {
                return;
            }

            // Définit la fonction pour lever le bouton visuellement.
            const lift = () => {
                // Revérifie si le bouton est désactivé.
                if (
                    button.disabled ||
                    button.classList.contains('disabled') ||
                    button.getAttribute('aria-disabled') === 'true'
                ) {
                    return;
                }
                // Ajoute la classe d'élévation.
                button.classList.add('is-lifted');
            };

            // Définit la fonction pour réinitialiser l'effet.
            const reset = () => {
                // Retire la classe d'élévation.
                button.classList.remove('is-lifted');
            };

            // Active l'effet au survol avec le pointeur.
            button.addEventListener('pointerenter', lift);
            // Désactive l'effet quand le pointeur sort.
            button.addEventListener('pointerleave', reset);
            // Active l'effet quand le bouton prend le focus.
            button.addEventListener('focus', lift);
            // Désactive l'effet quand le focus est perdu.
            button.addEventListener('blur', reset);
        });
    </script>
    <!-- Début du script pour l'effet de lueur du curseur. -->
    <script>
        // Démarre une IIFE pour isoler les variables du script.
        (function () {
            // Arrête le script sur les appareils à pointeur grossier (ex: tactile).
            if (window.matchMedia('(pointer: coarse)').matches) {
                return;
            }

            // Crée un élément div pour la lueur du curseur.
            const glow = document.createElement('div');
            // Assigne une classe CSS à cet élément.
            glow.className = 'cursor-glow';
            // Ajoute la lueur au body du document.
            document.body.appendChild(glow);

            // Initialise la position actuelle sur l'axe X.
            let currentX = 0;
            // Initialise la position actuelle sur l'axe Y.
            let currentY = 0;
            // Initialise la position cible sur l'axe X.
            let targetX = 0;
            // Initialise la position cible sur l'axe Y.
            let targetY = 0;
            // Définit un objet d'offset pour ajuster la position.
            const offset = { x: 0, y: 0 };
            // Indique si la lueur est visible.
            let isVisible = false;

            // Fonction de mise à jour de la position de la lueur.
            const update = () => {
                // Interpole la position X vers la cible.
                currentX += (targetX - currentX) * 0.12;
                // Interpole la position Y vers la cible.
                currentY += (targetY - currentY) * 0.12;
                // Applique la transformation CSS pour positionner la lueur.
                glow.style.transform = `translate3d(${currentX}px, ${currentY}px, 0) translate3d(-50%, -50%, 0)`;
                // Redemande une frame d'animation.
                requestAnimationFrame(update);
            };

            // Gestionnaire pour les mouvements du pointeur.
            const handleMove = (event) => {
                // Met à jour la position cible X avec l'événement.
                targetX = event.clientX + offset.x;
                // Met à jour la position cible Y avec l'événement.
                targetY = event.clientY + offset.y;
                // Si la lueur n'est pas visible, on l'affiche.
                if (!isVisible) {
                    // Définit l'opacité à 1 pour montrer la lueur.
                    glow.style.opacity = '1';
                    // Met à jour l'état de visibilité.
                    isVisible = true;
                }
            };

            // Écoute les mouvements de pointeur sur le document.
            document.addEventListener('pointermove', handleMove);
            // Cache la lueur quand le pointeur quitte le document.
            document.addEventListener('pointerleave', () => {
                // Met l'opacité à 0 pour cacher la lueur.
                glow.style.opacity = '0';
                // Met à jour l'état de visibilité.
                isVisible = false;
            });

            // Lance la boucle d'animation initiale.
            update();
        })();
    </script>
    <!-- Chargement du bundle JavaScript de Bootstrap depuis un CDN. -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
