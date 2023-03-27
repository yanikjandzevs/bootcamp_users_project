users: {
  let selectors = {
    list_card: '.users',
    add_form: '#add_user',
    update_form: '#update_user',
    template: '#user_row'
  };

  let view = new View(selectors, {
    delete: function (ids) {
      const form_data = new FormData();
      form_data.set('id', ids)
      fetch('api.php?action=delete-users',{
        method: "POST",
        body: form_data
      }).then(function(response) {
        return response.json();
      }).then(function(result) {
        if (result.status == true) {
          // view.displayAllEntries(result.entries);
        }
      });
    },
    store_new: function (url, form_data, add_entry) {
      fetch(url, {
        method: "POST",
        body: form_data
      }).then(function (response) {
        return response.json();
      }).then(function (result) {
        if (result.status == true) {
          add_entry(result.entry.id, result.entry);
        }
      });
    },
    update_entry: function (url, form_data, update_entry) {
      fetch(url, {
        method: "POST",
        body: form_data
      }).then(function (response) {
        return response.json();
      }).then(function (result) {
        if (result.status == true) {
          update_entry(result.entry.id, result.entry);
        }
      });
    },
    start_update: function (id) {
      fetch(
        'api.php?action=get-single-user&id='+id
      ).then(function(response) {
        return response.json();
      }).then(function(result) {
        if (result.status == true) {
          let form = document.querySelector('#update_user');

          let id_field = form.querySelector('[name="id"]');
          if (id_field == null) {
            id_field = document.createElement('input');
            form.prepend(id_field);
          }
          id_field.setAttribute('name', 'id');
          id_field.setAttribute('type', 'hidden');
          id_field.value = result.entry.id;

          form.querySelector('[name="firstname"]').value = result.entry.firstname;
          form.querySelector('[name="lastname"]').value = result.entry.lastname;
          form.querySelector('[name="phone"]').value = result.entry.phone;
          form.querySelector('[name="email"]').value = result.entry.email;
          document.querySelector('.popup').classList.add('show');
        }
      });
    },
    add: function(row, entry) {
      row.querySelector('.full_name').textContent = entry.firstname + " " + entry.lastname;
      row.querySelector('.phone').textContent = entry.phone;
      row.querySelector('.email').textContent = entry.email;
      row.querySelector('.date').textContent = entry.created_at;
    },
    update: function(row, entry) {
      row.querySelector('.full_name').textContent = entry.firstname + " " + entry.lastname;
      row.querySelector('.phone').textContent = entry.phone;
      row.querySelector('.email').textContent = entry.email;
      document.querySelector('.popup').classList.remove('show');
    },
  });

  fetch(
    'api.php?action=get-users'
  ).then(function(response) {
    return response.json();
  }).then(function(result) {
    if (result.status == true) {
      view.displayAllEntries(result.entries);
    }
  });

  document.querySelector('.popup').addEventListener('click', function (event) {
    if (event.target.classList.contains('popup')) {
      this.classList.remove('show');
    }
  });

}