class Storage
{
  constructor(storage_name) {
    this.storage_name = storage_name;
    this.data = {
      entries: {},
      last_id: 0
    };
    const json = localStorage.getItem(this.storage_name);
    if (json != null) {
      const data = JSON.parse(json);
      if (typeof data == 'object') {
        this.data = data;
      }
    }
  }

  getAll () {
    const json = JSON.stringify(this.data.entries);
    return JSON.parse(json);
  }

  get(id) {
    const json = JSON.stringify(this.data.entries[id]);
    return JSON.parse(json);
  }

  create(obj) {
    const id = ++this.data.last_id;
    obj.id = id;
    this.data.entries[id] = obj;

    localStorage.setItem(this.storage_name, JSON.stringify(this.data));

    return id;
  }

  update (id, obj) {
    if (!this.data.entries.hasOwnProperty(id)) {
      return false;
    }

    this.data.entries[id] = obj;
    localStorage.setItem(this.storage_name, JSON.stringify(this.data));
  }

  delete (id) {
    if (!this.data.entries.hasOwnProperty(id)) {
      return false;
    }

    delete this.data.entries[id];
    localStorage.setItem(this.storage_name, JSON.stringify(this.data));
  }
}