<div class="card el_<?= $form_id; ?>">
  <div class="heading">
    <h5><?= $heading; ?></h5>
  </div>
  <form id="<?= $form_id; ?>" data-storage="users" action="<?= $url; ?>" method="post" class="content">
    <div class="row">
      <div class="col-5">
        <label>
          Firstname
          <input type="text" name="firstname" required />
        </label>
      </div>
      <div class="col-5">
        <label>
          Lastname
          <input type="text" name="lastname" required />
        </label>
      </div>
    </div>
    <div class="row">
      <div class="col-5">
        <label>
          Phone number
          <input type="text" name="phone" required />
        </label>
      </div>
      <div class="col-5">
        <label>
          Email address
          <input type="email" name="email" />
        </label>
      </div>
    </div>

    <p class="note"></p>

    <button type="submit" class="btn stretch">Save information</button>
  </form>
</div>