// Memastikan script berjalan setelah semua elemen HTML selesai dimuat
document.addEventListener('DOMContentLoaded', function() {
    
    // Mencari elemen input file berdasarkan ID
    const uploadInput = document.getElementById('upload-avatar');
    
    // Jika elemen ditemukan, tambahkan event pendengar saat ada file yang dipilih
    if (uploadInput) {
        uploadInput.addEventListener('change', function(event) {
            const reader = new FileReader();
            
            reader.onload = function(){
                const preview = document.getElementById('avatarPreview');
                const icon = document.getElementById('avatarIcon');
                
                if (preview) {
                    preview.src = reader.result;
                    preview.style.display = 'block';
                }
                
                if (icon) {
                    icon.style.display = 'none';
                }
            }
            
            if(event.target.files[0]){
                reader.readAsDataURL(event.target.files[0]);
            }
        });
    }
});