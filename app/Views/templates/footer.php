    </main><!-- /.app-content -->
  </div><!-- /.app-main -->
</div><!-- /.app-wrapper -->

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<!-- Custom JS (dark mode, greeting, dsb) -->
<script src="<?= base_url('assets/js/main.js') ?>"></script>

<?php // Script tambahan khusus per halaman (misal init Chart.js) bisa dikirim
     // lewat variabel $pageScript saat memanggil view ini. Contoh pemakaian
     // ada di app/Views/dashboard/index.php ?>
<?= $pageScript ?? '' ?>

</body>
</html>
