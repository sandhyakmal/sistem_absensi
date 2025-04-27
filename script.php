<script>
        $(document).ready(function() {
            $('#salary, #upah_lembur, #potongan, #bonus, #lembur,#total_lembur, #total').mask('#.##0', {reverse: true});
        });

        $(document).ready(function() {
            $('#datatable').DataTable();
        });

        // START  TAMBAH INPUTAN  TAMBAH JADWAL KERJA
        $(document).ready(function() {
            // Menambahkan baris baru
            $('#tambah-baris').on('click', function() {
                let barisBaru = `<tr>
                                     <td>
                                        <div class="col-md-12">
                                            <select required class="form-select" name="iduser[]" aria-label="Floating label select example">
                                                <option selected disabled value="">Pilih Nama Karyawan</option>
                                                <?php
                                                
                                                $sql_user = "SELECT * FROM tb_user where role = 'karyawan' ";
                                                $result = $conn->query($sql_user);

                                                if ($result->num_rows > 0) {
                                                    // Loop setiap row dan tambahkan sebagai option
                                                    while($row = $result->fetch_assoc()) {
                                                        echo '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
                                                    }
                                                } else {
                                                    echo '<option disabled>Tidak ada data</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-md-12">
                                            <select name="shift[]" class="form-select">
                                                <option value="" disabled selected>- Pilih Shift Kerja -</option>
                                                <option value="1">Shift 1 (13.00 - 18.00)</option>
                                                <option value="2">Shift 2 (18.00 - 23.00)</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td><button type="button" class="btn btn-danger hapus-baris">Hapus</button></td>
                                </tr>`;
                $('#tabel-input tbody').append(barisBaru);
            });

            // Menghapus baris
            $('#tabel-input').on('click', '.hapus-baris', function() {
                $(this).closest('tr').remove();
            });
        });

        //END INPUTAN TAMBAH JADWAL
        
        // START VALIDASI INPUTAN KETIKA MENAMBAHKAN JADWAL KERJA KARYAWAN
        function validateForm() {
            const idUsers = document.querySelectorAll("select[name='iduser[]']");
            const selectedIds = [];

            for (let i = 0; i < idUsers.length; i++) {
                const selectedId = idUsers[i].value;
                if (selectedId && selectedIds.includes(selectedId)) {
                    alert("Nama karyawan sudah ada di tanggal tersebut.");
                    return false;
                }
                selectedIds.push(selectedId);
            }
            return true;
        }
         
        // END VALIDASI INPUTAN KETIKA MENAMBAHKAN JADWAL KERJA KARYAWAN

        // function updateDateTime() {
        //     const dateTimeInput = document.getElementById("datetimeInput");
        //     const now = new Date();

        //     // Format tanggal dan waktu untuk tipe datetime-local
        //     const year = now.getFullYear();
        //     const month = String(now.getMonth() + 1).padStart(2, '0');
        //     const day = String(now.getDate()).padStart(2, '0');
        //     const hours = String(now.getHours()).padStart(2, '0');
        //     const minutes = String(now.getMinutes()).padStart(2, '0');
        //     const seconds = String(now.getSeconds()).padStart(2, '0');

        //     // Gabungkan menjadi format datetime-local
        //     const formattedDateTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

        //     // Set nilai input dengan waktu saat ini
        //     dateTimeInput.value = formattedDateTime;
        // }

        // // Update datetime setiap detik
        // setInterval(updateDateTime, 1000);

    
        // START GET WAKTU INPUT JAM IN DAN JAM OUT
        function updateTime() {
            const timeInput = document.getElementById("timeInput");
            if (timeInput) {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                const formattedTime = `${hours}:${minutes}:${seconds}`;
                timeInput.value = formattedTime;
            } else {
                console.error("Elemen dengan id 'timeInput' tidak ditemukan.");
            }
        }

        setInterval(updateTime, 1000);
        // END GET WAKTU INPUT JAM IN DAN JAM OUT

        // START FOTO ABSEN
        let stream; 

        // Event saat modal dibuka
        var myModal = document.getElementById('basicModal');
        myModal.addEventListener('shown.bs.modal', function () {
            if (!stream) { 
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(function(s) {
                        stream = s;
                        document.getElementById('video').srcObject = stream;
                    })
                    .catch(function(error) {
                        console.log('Gagal akses kamera: ', error);
                    });
            }
        });

        // Event saat modal ditutup (opsional: jika mau matikan kamera)
        myModal.addEventListener('hidden.bs.modal', function () {
            if (stream) {
                let tracks = stream.getTracks();
                tracks.forEach(track => track.stop());
                stream = null;
            }
        });

        // Event tombol ambil foto
        document.getElementById('capture').addEventListener('click', function(event) {
            event.preventDefault(); // Supaya tidak submit form atau nutup modal

            var canvas = document.getElementById('canvas');
            var video = document.getElementById('video');
            var context = canvas.getContext('2d');

            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            canvas.style.display = "block"; // Pastikan canvas kelihatan setelah capture
            
            // Simpan foto ke hidden input (Base64)
            var dataURL = canvas.toDataURL('image/png');
            document.getElementById('image_data').value = dataURL;
        });
        // END FOTO ABSEN

</script>