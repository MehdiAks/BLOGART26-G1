    </main>
    <footer class="site-footer border-top py-5" id="Contact">
        <div class="container">
            <div class="row gy-4 align-items-start">
                <div class="col-lg-5">
                    <a class="btn-contact-footer" href="contact.php">CONTACTEZ-NOUS!</a>
                    <p class="mb-1">secretariat@bec-bordeaux</p>
                    <p class="mb-3">06 71 94 23 80 - 05 56 91 83 50</p>
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <a href="https://www.instagram.com/becfootballclub/?hl=fr" class="social-icon">
                            <img src="<?php echo ROOT_URL . '/src/images/instagram-logo.png'; ?>" alt="Instagram">
                        </a>
                        <a href="https://www.facebook.com/becofficiel/?locale=fr_FR" class="social-icon">
                            <img src="<?php echo ROOT_URL . '/src/images/facebook-logo.png'; ?>" alt="Facebook">
                        </a>
                    </div>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li>
                            <a href="<?php echo ROOT_URL . '/infoleg/cgu.php'; ?>">Conditions d’utilisation</a>
                        </li>
                        <li>
                            <a href="<?php echo ROOT_URL . '/infoleg/mentionleg.php'; ?>">Mentions légales</a>
                        </li>
                        <li>
                            <a href="<?php echo ROOT_URL . '/infoleg/rgpd.php'; ?>">RGPD</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-4">
                    <div class="ratio ratio-4x3 rounded-4 overflow-hidden shadow-sm">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2829.921341579605!2d-0.5763837240139745!3d44.82316707598102!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd5527ba88e01e2d%3A0xf8bc9e94e84c6e71!2s51%20Rue%20Pauline%20Kergomard%2C%2033800%20Bordeaux!5e0!3m2!1sfr!2sfr!4v1769782356902!5m2!1sfr!2sfr"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script>
        document.querySelectorAll('.header-submenu').forEach((submenu) => {
            const toggle = submenu.querySelector('.submenu-toggle');
            const closeSubmenu = () => {
                submenu.classList.remove('is-open');
                if (toggle) {
                    toggle.setAttribute('aria-expanded', 'false');
                }
            };

            if (!toggle) {
                return;
            }

            toggle.addEventListener('click', (event) => {
                event.preventDefault();
                const isOpen = submenu.classList.contains('is-open');

                document.querySelectorAll('.header-submenu.is-open').forEach((openSubmenu) => {
                    if (openSubmenu !== submenu) {
                        const openToggle = openSubmenu.querySelector('.submenu-toggle');
                        openSubmenu.classList.remove('is-open');
                        if (openToggle) {
                            openToggle.setAttribute('aria-expanded', 'false');
                        }
                    }
                });

                if (isOpen) {
                    closeSubmenu();
                } else {
                    submenu.classList.add('is-open');
                    toggle.setAttribute('aria-expanded', 'true');
                }
            });

            document.addEventListener('click', (event) => {
                if (!submenu.contains(event.target)) {
                    closeSubmenu();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeSubmenu();
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
