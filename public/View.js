class View
{
  // constructor(all_entries, list_card_selector, form_selector, template_selector, callbacks) {
  constructor(selectors, callbacks) {
    this.selected_entry_ids = [];
    this.add_form = document.querySelector(selectors.add_form);
    this.update_form = document.querySelector(selectors.update_form);

    this.note = this.add_form.querySelector('.note');

    this.callbacks = callbacks;

    const obj = this;

    if (
      selectors.hasOwnProperty('list_card') &&
      selectors.hasOwnProperty('template')
    ) {
      this.list_card = document.querySelector(selectors.list_card);
      this.list_table = this.list_card.querySelector('.list_table');
      this.remove_btn = this.list_card.querySelector('.remove_btn');
      this.update_btn = this.list_card.querySelector('.update_btn');
      this.table_heading = this.list_table.querySelector('.table_heading');
      this.template = document.querySelector(selectors.template);
  
      this.remove_btn.addEventListener('click', function () {
        obj.handleRemove();
      });

      this.update_btn.addEventListener('click', function () {
        obj.handleStartUpdate();
      });
    }

    if (this.add_form != null) {
      this.add_form.addEventListener('submit', function (event) {
        event.preventDefault();
        obj.handleAddEntryFormSubmit();
      });
    }


    if (this.update_form != null) {
      this.update_form.addEventListener('submit', function (event) {
        event.preventDefault();
        obj.handleUpdateEntryFormSubmit();
      });
    }
  }

  displayAllEntries(all_entries) {
    for (let id in all_entries) displayEntry: {
      this.addEntry(id, all_entries[id]);
    }
  }

  addEntry(id, entry) {
    if (!this.hasOwnProperty('template')) {
      return;
    }
    const obj = this;
    const new_row = this.template.content.cloneNode(true);

    if (this.callbacks.hasOwnProperty('add')) {
      this.callbacks.add(new_row, entry);
    }

    obj.table_heading.after(new_row);
    const new_row_element = obj.table_heading.nextSibling.nextSibling;
  
    new_row_element.dataset.id = id;
    new_row_element.querySelector('[type=checkbox]').addEventListener('change', function () {
      obj.handleCheckboxChange(new_row_element, this);
    });
  }

  updateEntry(id, entry) {
    const row = this.list_table.querySelector('[data-id="' + id + '"]');

    if (this.callbacks.hasOwnProperty('update')) {
      this.callbacks.update(row, entry);
    }

    row.querySelector('[type=checkbox]').checked = false;
    this.selected_entry_ids = [];
  }

  handleCheckboxChange (row, checkbox) {
    if (checkbox.checked) add_to_list: {
      this.selected_entry_ids.push(row.dataset.id);
    }
    else remove_from_list: {
      const index = this.selected_entry_ids.indexOf(row.dataset.id);
      if (index != -1) {
        this.selected_entry_ids.splice(index, 1);
      }
    }
  }

  handleRemove() {
    for (let index = 0; index < this.selected_entry_ids.length; index++) {
      const user_id = this.selected_entry_ids[index];
      this.list_table.querySelector('[data-id="' + user_id + '"]').remove();
    }

    if (this.callbacks.hasOwnProperty('delete')) {
      this.callbacks.delete(this.selected_entry_ids);
    }

    this.selected_entry_ids = [];
  }

  handleStartUpdate() {
    if (this.selected_entry_ids.length > 1) {
      alert('can update only by one user!');
      return;
    }
    if (this.selected_entry_ids.length == 0) {
      return;
    }

    if (this.callbacks.hasOwnProperty('start_update')) {
      this.callbacks.start_update(this.selected_entry_ids[0]);
    }
  }

  handleAddEntryFormSubmit() {
    const data = new FormData(this.add_form);
    // const new_entry = {};
  
    // for (let key of data.keys()) {
    //   new_entry[key] = data.get(key);
    // }

    if (this.callbacks.hasOwnProperty('store_new')) {
      const obj = this;
      this.callbacks.store_new(this.add_form.action, data, function (id, entry) {
        obj.addEntry(id, entry);
        obj.note.textContent = "This account was created on " + entry.created_at;
      });
      
    }
    this.add_form.reset();
  }

  handleUpdateEntryFormSubmit() {
    const data = new FormData(this.update_form);

    if (this.callbacks.hasOwnProperty('update_entry')) {
      const obj = this;
      this.callbacks.update_entry(this.update_form.action, data, function (id, entry) {
        obj.updateEntry(id, entry);
      });
    }
  }
}


