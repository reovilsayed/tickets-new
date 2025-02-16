<div class="modal fade" tabindex="-1" id="order-number-email-change-modal">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body container">
        <form action="#" id="order-action-form" method="POST">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="mb-3 col-md-6">
              <label for="email" class="form-label">Email address</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="johndoe@example.com">
            </div>
            <div class="mb-3 col-md-6">
              <label for="phone" class="form-label">Phone Number</label>
              <input type="text" class="form-control" id="phone" name="phone" placeholder="phone number">
            </div>
            <div class="col-md-12">
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('javascript')
  <script>
    (function() {
      const orderTableBody = document.getElementById('{{ $id ?? 'order-table-body' }}');

      orderTableBody.addEventListener('click', (e) => {
        const el = e.target;

        if (!el.classList.contains('order-action-button')) {
          return;
        }

        const url = el.dataset.url;

        const formEl = document.getElementById('order-action-form');
        const emailEl = formEl.querySelector('[name=email]');
        const phoneEl = formEl.querySelector('[name=phone]');

        emailEl.value = el.dataset.email;
        phoneEl.value = el.dataset.phone;

        formEl.action = url;
      });

      let _hasDataChange = false;

      const ticketActionForm = document.getElementById('order-action-form');
      ticketActionForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formEl = e.target;
        const phone = formEl.querySelector('[name=phone]').value;
        const email = formEl.querySelector('[name=email]').value;

        axios.put(formEl.action, {
            phone,
            email
          })
          .then(res => {
            toastr.success('Successfully updated');
            _hasDataChange = true;
          })
          .catch(err => {
            if (err.status !== 422) {
              throw err;
            }

            const errors = err.response.data.errors;

            for (const property in errors) {
              const msg = errors[property][0];
              toastr.error(msg);

            }

          });

      });

      $('#order-number-email-change-modal').on('hidden.bs.modal', function(e) {
        if (_hasDataChange) {
          location.reload()
        }
      });
    })()
  </script>
@endpush
