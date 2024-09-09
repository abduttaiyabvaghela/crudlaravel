$(document).ready(function () {
    let memberIndex = 0;

    // Handle marital status change
    $('#marital_status').change(function () {
        let weddingDateField = $('#wedding_date').closest('.wedding-date');
        if ($(this).val() === 'married') {
            weddingDateField.show();
        } else {
            weddingDateField.hide();
        }
    });

    // Add new hobby field
    $('#add-hobby').click(function () {
        $('#hobby-fields').append(`
            <div class="input-group mb-2">
                <input type="text" name="hobbies[]" class="form-control" placeholder="Enter hobby">
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-hobby">Remove</button>
                </div>
            </div>`);
    });

    // Remove hobby field
    $(document).on('click', '.remove-hobby', function () {
        $(this).closest('.input-group').remove();
    });

    // Add new family member field
    $('#add-family-member').click(function () {
        $('#family-member-fields').append(`
            <div class="family-member mb-3 p-3 border rounded">
                <div class="form-group mb-2">
                    <label>Member Name</label>
                    <input type="text" name="family_members[${memberIndex}][name]" class="form-control" placeholder="Enter member's name" required>
                </div>
                <div class="form-group mb-2">
                    <label>Birthdate</label>
                    <input type="date" name="family_members[${memberIndex}][birthdate]" class="form-control" required>
                </div>
                <div class="form-group mb-2">
                    <label>Marital Status</label>
                    <select name="family_members[${memberIndex}][is_married]" class="form-control marital-status">
                        <option value="0">Unmarried</option>
                        <option value="1">Married</option>
                    </select>
                </div>
                <div class="form-group wedding-date" style="display:none;">
                    <label>Wedding Date</label>
                    <input type="date" name="family_members[${memberIndex}][wedding_date]" class="form-control">
                </div>
                <div class="form-group mb-2">
                    <label>Education</label>
                    <input type="text" name="family_members[${memberIndex}][education]" class="form-control" placeholder="Enter education details" required>
                </div>
                <button type="button" class="btn btn-danger remove-member">Remove Member</button>
            </div>`);
        memberIndex++;
    });

    // Handle marital status change in family members
    $(document).on('change', '.marital-status', function () {
        let weddingDateField = $(this).closest('.family-member').find('.wedding-date');
        if ($(this).val() === '1') {
            weddingDateField.show();
        } else {
            weddingDateField.hide();
        }
    });

    // Remove family member field
    $(document).on('click', '.remove-member', function () {
        $(this).closest('.family-member').remove();
    });

    // Submit form with AJAX
    $('#family-form').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert(response.message);
                window.location.href = "/families";
            },
            error: function (xhr) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });

    $('.marital-status').each(function () {
        $(this).trigger('change');
    });
});

// Function to show family details
function showFamilyDetails(familyId) {
    $.ajax({
        url: '/families/' + familyId,
        method: 'GET',
        success: function(data) {
            $('#head-of-family-name').text(data.family.name + ' ' + data.family.surname);
            $('#head-of-family-photo').attr('src', data.photo_url);
            
            let membersTableBody = '';
            data.members.forEach(member => {
                membersTableBody += `
                    <tr>
                        <td>${member.name}</td>
                        <td>${member.birthdate}</td>
                        <td>${member.is_married ? 'Married' : 'Unmarried'}</td>
                        <td>${member.wedding_date ? member.wedding_date : 'N/A'}</td>
                        <td>${member.education}</td>
                    </tr>`;
            });
            $('#family-members-table-body').html(membersTableBody);

            $('#familyDetailsModal').modal('show');
        }
    });
}

// Function to delete a family
function deleteFamily(familyId) {
    if (confirm("Are you sure you want to delete this family?")) {
        $.ajax({
            url: '/families/' + familyId,
            type: 'DELETE',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert('Family deleted successfully.');
                location.reload();
            },
            error: function(response) {
                alert('Error deleting family. Please try again.');
            }
        });
    }
}
