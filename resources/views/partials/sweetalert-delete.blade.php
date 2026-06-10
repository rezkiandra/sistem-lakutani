<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function konfirmasiHapus(event, formId, namaData) {
    // Blokir aksi bawaan agar form tidak langsung terkirim
    event.preventDefault();

    Swal.fire({
      title: 'Yakin Ingin Menghapus Data?',
      text: `${namaData} akan dihapus secara permanen dari sistem. Tindakan ini tidak dapat dibatalkan.`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc2626', // Merah Slate/Tailwind
      cancelButtonColor: '#64748b', // Abu-abu Slate
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal',
      reverseButtons: true, // Memposisikan tombol 'Batal' di sebelah kiri secara natural
      focusCancel: true // Otomatis fokus ke tombol batal demi keamanan UX
    }).then((result) => {
      if (result.isConfirmed) {
        // Eksekusi pengiriman data form tersembunyi ke route destroy controller
        document.getElementById(formId).submit();
      }
    });
  }
</script>
