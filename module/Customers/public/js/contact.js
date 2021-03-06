$(document).ready(function () {
    /*
     * Function to add contact to database and link to customer
     */
    $("form#Contact").submit(function (e) {
        e.preventDefault();
        $(function () {
            $('#contactModal').modal('toggle');
        });
        $.ajax({
            type: 'POST',
            data: {
                formData: $(this).serialize()
            },
            url: "/beheer/contacts/add",
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data.success === true) {
                    var row = '';
                    row += '<tr>';
                    row += '<td>' + data.contact.surName + '</td>';
                    row += '<td>' + data.contact.lastNamePrefix + '</td>';
                    row += '<td>' + data.contact.lastName + '</td>';
                    var gender = '<i class="fas fa-genderless"></i>';
                    switch (data.contact.gender) {
                        case '1':
                            gender = '<i class="fas fa-male"></i>';
                            break;
                        case '2':
                            gender = '<i class="fas fa-female"></i>';
                            break;
                        case '2':
                            gender = '<i class="fas fa-genderless"></i>';
                            break;
                    }

                    row += '<td>' + gender + '</td>';
                    row += '<td class="text-center">';
                    row += '    <a class="btn btn-dark btn-sm" href="/beheer/contacts/edit/'+data.contact.id+'">';
                    row += '        <i class="fas fa-edit"></i>';
                    row += '    </a>';
                    row += '    <a class="btn btn-danger btn-sm" href="/beheer/contacts/delete/'+data.contact.id+'">';
                    row += '        <i class="fas fa-trash"></i>';
                    row += '    </a>';
                    row += '    <a class="btn btn-dark btn-sm" href="/beheer/contacts/show/'+data.contact.id+'">';
                    row += '        <i class="fas fa-search-plus"></i>';
                    row += '    </a>';
                    row += '</td>';
                    row += '</tr>';
                    $('table#contactsTable > tbody').append(row);
                } else {
                    alert(data.errorMessage);
                }
            }
        });
    });
});