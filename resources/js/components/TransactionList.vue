<template>
  <div class="uk-grid uk-grid-small uk-child-width-1-1" uk-grid>
    <div class="uk-card uk-card-default">
      <div class="uk-card-header uk-padding-small">
        <div
          class="uk-width-expand uk-flex uk-flex-inline uk-flex-between uk-flex-wrap uk-flex-wrap-between"
        >
          <h3 class="uk-card-title uk-margin-remove-bottom uk-text-capitalize">
            {{ transaction_status }} Transaction
          </h3>
          <ul class="uk-iconnav">
            <li>
              <button
                @click="load_data('pending', 1)"
                class="uk-button uk-button-link"
              >
                <i class="mdi mdi-24px mdi-timelapse grey-text"></i>
              </button>
            </li>
            <li>
              <button
                @click="load_data('confirmed', 1)"
                class="uk-button uk-button-link"
              >
                <i class="mdi mdi-24px mdi-check-all  green-text accent-2"></i>
              </button>
            </li>
            <li>
              <button
                @click="load_data('failed', 1)"
                class="uk-button uk-button-link"
              >
                <i class="mdi mdi-24px mdi-clock-alert red-text accent-2"></i>
              </button>
            </li>
          </ul>
        </div>
      </div>
      <div class="uk-card-body uk-padding-remove">
        <table
          class="uk-table uk-table-middle uk-table-responsive uk-table-divider"
        >
          <thead>
            <tr>
              <th class="uk-text-left">#</th>
              <th class="uk-text-right">Amount</th>
              <th class="uk-text-right">Sender</th>
              <th class="uk-text-right">Reciever</th>
              <th class="uk-text-right">POP</th>
              <th class="uk-text-right">Time</th>
              <th class="uk-text-right">Status</th>
              <th
                v-if="transaction_status != 'confirmed'"
                class="uk-text-right"
              >
                Action
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(transaction, index) in transactions"
              :id="`transaction_${transaction.id}`"
              :key="transaction.id"
            >
              <td>{{ index + 1 }}</td>
              <td class="uk-text-right">{{ Number(transaction.amount) }}</td>
              <td class="uk-text-right">{{ transaction.sender }}</td>
              <td class="uk-text-right">{{ transaction.reciever }}</td>
              <td class="uk-text-right">
                <span v-if="transaction.pop == null" class="uk-label">NaN</span>
                <span
                  v-else
                  @click="view_pop(transaction.pop_url)"
                  style="cursor: pointer;"
                  class="uk-label"
                  >View POP</span
                >
              </td>
              <td class="uk-text-right">
                {{ transaction.time_diff }}
              </td>
              <td class="uk-text-right">
                <span
                  v-if="transaction.status === 'pending'"
                  class="blue-text mdi mdi-18px mdi-pencil-plus"
                ></span>
                <span
                  v-if="transaction.status === 'failed'"
                  class="red-text mdi mdi-18px mdi-close"
                ></span>
                <span
                  v-if="transaction.status === 'confirmed'"
                  class="green-text mdi mdi-18px mdi-check-all"
                ></span>
              </td>
              <td
                v-if="transaction_status != 'confirmed'"
                class="uk-text-right"
              >
                <div class="uk-button-group">
                  <button
                    @click="confirm_transaction(transaction.id)"
                    :id="`confirm_trnx_${transaction.id}_btn`"
                    title="Confirm this Transaction"
                    class="uk-button green accent-2  uk-button-small white-text"
                  >
                    <i class="mdi mdi-24px mdi-check"></i>
                  </button>
                  <button
                    v-if="transaction_status == 'failed'"
                    @click="revoke_transaction(transaction.id)"
                    :id="`revoke_trnx_${transaction.id}_btn`"
                    title="Rematch this Transaction"
                    class="uk-button red accent-2  uk-button-small white-text"
                  >
                    <i class="mdi mdi-24px mdi-refresh"></i>
                  </button>
                  <button
                    v-else
                    @click="delete_transaction(transaction.id)"
                    :id="`delete_trnx_${transaction.id}_btn`"
                    title="Delete this Transaction"
                    class="uk-button red accent-2  uk-button-small white-text"
                  >
                    <i class="mdi mdi-24px mdi-close"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="uk-text-center uk-card-footer">
        <paginate
          v-if="pagination_data.record_count > 0"
          v-model="pagination_data.current_page"
          :page-count="pagination_data.page_count"
          :page-range="3"
          :margin-pages="2"
          :prev-text="'<span uk-pagination-previous></span>'"
          :next-text="'<span uk-pagination-next></span>'"
          :container-class="'uk-pagination uk-flex-center'"
          :active-class="'uk-active'"
          :disable-class="'uk-disabled'"
          :click-handler="page_swap"
        >
        </paginate>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      transactions: [],
      selected_transaction: null,
      transaction_status: "pending",
      pagination_data: {
        page_count: 0,
        current_page: 1,
        record_count: 0
      }
    };
  },
  created() {
    this.load_data("pending", 1);
  },
  methods: {
    // select_transaction(transaction) {
    //   this.selected_transaction = transaction;
    // },
    load_data(transaction_status, page = 1) {
      this.transaction_status = transaction_status;
      axios
        .get(
          `${window.location.origin}/api/admin/transaction/list_all/${transaction_status}?page=${page}`
        )
        .then(res => {
          this.transactions = res.data.transactions.data;
          this.load_pagination_data(
            res.data.transactions.last_page,
            res.data.transactions.current_page,
            res.data.transactions.total
          );
        })
        .catch(err => {
          console.log({ err: err.message });
        });
    },
    page_swap(page = this.pagination_data.current_page) {
      if (page > this.pagination_data.page_count || page < 1) {
        let page = 1;
      }
      this.load_data(this.transaction_status, page);
      return;
    },
    load_pagination_data(last_page, current_page, total_records) {
      this.pagination_data = {
        page_count: last_page,
        current_page: current_page,
        record_count: total_records
      };
      return;
    },
    view_pop(param) {
      let pop_url = param;
      this.$swal.fire({
        showCloseButton: true,
        confirmButtonText: "Ok",
        title: "Viewing POP",
        html: `<img data-src='${window.location.origin}/image/pop/${pop_url}' width='400' height='200' alt='pop placeholder' style='height:50vh;object-fit:cover;' class='uk-width-1-1 uk-border-rounded' uk-img>`,
        onDestroy: () => {
          pop_url = null;
        }
      });
    },
    confirm_transaction(transaction_id) {
      let current_page = this.pagination_data.current_page;
      let transaction_status = this.transaction_status;
      this.$swal
        .fire({
          title: "Confirm?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Confirm",
          cancelButtonText: "Cancel"
        })
        .then(result => {
          if (result.value) {
            axios
              .get(
                `${window.location.origin}/api/user/transaction/confirm/${transaction_id}`
              )
              .then(res => {
                this.$swal.fire({
                  title: `Success: ${res.statusText}`,
                  text: `${res.data.message}`,
                  icon: "success",
                  onDestroy: () => {
                    this.load_data(transaction_status, current_page);
                  }
                });
                return;
              })
              .catch(err => {
                console.log({ err: err.message });
                this.$swal.fire({
                  title: "Failed: " + `${err.response.statusText}`,
                  icon: "error",
                  text: `${err.response.data.message}`,
                  onDestroy: () => {
                    this.load_data(transaction_status, current_page);
                  }
                });
              });
          }
        });
    },
    delete_transaction(transaction_id) {
      let current_page = this.pagination_data.current_page;
      let transaction_status = this.transaction_status;
      this.$swal
        .fire({
          title: "Confirm?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Confirm",
          cancelButtonText: "Cancel"
        })
        .then(result => {
          if (result.value) {
            axios
              .get(
                `${window.location.origin}/api/user/transaction/delete/${transaction_id}`
              )
              .then(res => {
                this.load_data(transaction_status, current_page);
                this.$swal.fire({
                  title: `Success: ${res.statusText}`,
                  text: `${res.data.message}`,
                  icon: "success"
                });
                return;
              })
              .catch(err => {
                console.log({ err: err.message });
                this.load_data(transaction_status, current_page);
                this.$swal.fire({
                  title: "Failed: " + `${err.response.statusText}`,
                  icon: "error",
                  text: `${err.response.data.message}`
                });
              });
          }
        });
    },
    revoke_transaction(transaction_id) {
      let current_page = this.pagination_data.current_page;
      let transaction_status = this.transaction_status;
      this.$swal
        .fire({
          title: "Confirm?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Confirm",
          cancelButtonText: "Cancel"
        })
        .then(result => {
          if (result.value) {
            axios
              .get(
                `${window.location.origin}/api/user/transaction/revoke/${transaction_id}`
              )
              .then(res => {
                this.load_data(transaction_status, current_page);
                this.$swal.fire({
                  title: `Success: ${res.statusText}`,
                  text: `${res.data.message}`,
                  icon: "success"
                });
                return;
              })
              .catch(err => {
                console.log({ err: err.message });
                this.load_data(transaction_status, current_page);
                this.$swal.fire({
                  title: "Failed: " + `${err.response.statusText}`,
                  icon: "error",
                  text: `${err.response.data.message}`
                });
              });
          }
        });
    }
  }
};
</script>
<style scoped>
/* tr:hover {
  cursor: pointer;
} */
</style>
