<script>
        $(document).ready(function() {
            $('#salary, #upah_lembur, #potongan, #bonus, #lembur,#total_lembur, #total').mask('#.##0', {reverse: true});
        });

        $(document).ready(function() {
            $('#datatable').DataTable();
        });

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

        function updateDateTime() {
            const dateTimeInput = document.getElementById("datetimeInput");
            const now = new Date();

            // Format tanggal dan waktu untuk tipe datetime-local
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            // Gabungkan menjadi format datetime-local
            const formattedDateTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

            // Set nilai input dengan waktu saat ini
            dateTimeInput.value = formattedDateTime;
        }

        // Update datetime setiap detik
        setInterval(updateDateTime, 1000);

    
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

        // Update waktu setiap detik
        setInterval(updateTime, 1000);
        
</script>