<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>copyright &copy;
                <script>
                    document.write(new Date().getFullYear());
                </script> - Sistem Donasi PMI
            </span>
        </div>
    </div>
</footer>
<!-- Footer -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

<script>
    function toggleUserMenu(e) {
        e.preventDefault();

        const menu = document.getElementById('userMenu');

        if (menu.style.display === 'block') {
            menu.style.display = 'none';
        } else {
            menu.style.display = 'block';
        }
    }

    // Tutup dropdown jika klik di luar
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('userMenu');
        const trigger = document.getElementById('userDropdown');

        if (!trigger.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });
</script>
