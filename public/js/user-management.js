document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-user-management');
    if (!form) return;

    // Inisialisasi DataTable
    let userTable = null;
    if (window.LaravelDataTables && window.LaravelDataTables['user-management-table']) {
        userTable = window.LaravelDataTables['user-management-table'];
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Clear previous errors
        ['name', 'email', 'password', 'password_confirmation', 'role'].forEach(field => {
            const errorSpan = document.querySelector(`.${field}_error`);
            if (errorSpan) errorSpan.textContent = '';
        });

        const formData = new FormData(form);
        const url = form.action;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: formData,
        })
        .then(response => {
            if (response.status === 422) {
                return response.json().then(data => {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            const errorSpan = document.querySelector(`.${key}_error`);
                            if (errorSpan) errorSpan.textContent = data.errors[key][0];
                        });
                    }
                    throw new Error('Validation error');
                });
            }
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            alert('User berhasil ditambahkan');
            form.reset();
            // Reload DataTable jika ada
            if (userTable) {
                userTable.ajax.reload(null, false);
            } else {
                // fallback reload halaman jika DataTable tidak ditemukan
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
