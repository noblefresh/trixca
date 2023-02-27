<template>
  <div class="uk-grid uk-grid-small uk-child-width-1-1" uk-grid>
    <div class="uk-card uk-card-default">
      <div class="uk-card-header uk-padding-small">
        <div
          class="uk-width-expand uk-flex uk-flex-inline uk-flex-between uk-flex-wrap uk-flex-wrap-between"
        >
          <h3 class="uk-card-title uk-margin-remove-bottom uk-text-capitalize">
            {{ cashout_type }} Cashout
          </h3>
          <ul class="uk-iconnav">
            <li>
              <button
                @click="load_data('open')"
                class="uk-button uk-button-link"
              >
                <i class="mdi mdi-24px mdi-timelapse grey-text"></i>
              </button>
            </li>
            <li>
              <button
                @click="load_data('closed')"
                class="uk-button uk-button-link"
              >
                <i class="mdi mdi-24px mdi-check-all  green-text accent-2"></i>
              </button>
            </li>
            <li>
              <button
                @click="load_data('disabled')"
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
              <th class="uk-text-right">Recieved</th>
              <th v-if="cashout_type == 'open'" class="uk-text-right">
                Recieving
              </th>
              <th v-if="cashout_type == 'open'" class="uk-text-right">Avail</th>
              <th class="uk-text-right">User</th>
              <th class="uk-text-right">Time</th>
              <th class="uk-text-right">Type</th>
              <th class="uk-text-right">Status</th>
              <th class="uk-text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(cashout, index) in cashouts"
              :id="`free_cashout_${cashout.id}`"
              :key="cashout.id"
            >
              <td>{{ index + 1 }}</td>
              <td class="uk-text-right">{{ Number(cashout.total_amount) }}</td>
              <td class="uk-text-right">
                {{ Number(cashout.recieved_amount) }}
              </td>
              <td v-if="cashout_type == 'open'" class="uk-text-right">
                {{ Number(cashout.recieving_amount) }}
              </td>
              <td v-if="cashout_type == 'open'" class="uk-text-right">
                {{
                  Number(cashout.total_amount) -
                    (Number(cashout.recieved_amount) +
                      Number(cashout.recieving_amount))
                }}
              </td>
              <td class="uk-text-right">
                {{ cashout.reciever }}
              </td>
              <td class="uk-text-right">
                {{ cashout.time_diff }}
              </td>
              <td class="uk-text-right">
                <span class="uk-label">{{ cashout.type }}</span>
              </td>
              <td class="uk-text-right">
                <span
                  v-if="cashout.status === 'open'"
                  class="blue-text mdi mdi-18px mdi-pencil-plus"
                ></span>
                <span
                  v-if="cashout.status === 'locked'"
                  class="grey-text mdi mdi-18px mdi-timelapse"
                ></span>
                <span
                  v-if="cashout.status === 'awaiting_roi'"
                  class="blue-text mdi mdi-18px mdi-timelapse"
                ></span>
                <span
                  v-if="cashout.status === 'closed'"
                  class="green-text mdi mdi-18px mdi-check-all"
                ></span>
              </td>
              <td v-show="cashout_type === 'open'" class="uk-text-right">
                <button
                  v-if="
                    Math.floor(
                      Number(cashout.recieved_amount) +
                        Number(cashout.recieving_amount)
                    ) === 0 && cashout.type === 'gift'
                  "
                  @click="delete_cashout(cashout.id)"
                  class="red-text mdi mdi-18px mdi-close"
                ></button>
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
      cashouts: [],
      selected_cashout: null,
      cashout_type: "open",
      pagination_data: {
        page_count: 0,
        current_page: 1,
        record_count: 0
      }
    };
  },
  created() {
    this.load_data("open", 1);
  },
  methods: {
    // select_cashout(cashout) {
    //   this.selected_cashout = cashout;
    // },
    load_data(cashout_type, page = 1) {
      this.cashout_type = cashout_type;
      axios
        .get(
          `${window.location.origin}/api/admin/cashout/list/${cashout_type}?page=${page}`
        )
        .then(res => {
          this.cashouts = res.data.data;
          this.load_pagination_data(
            res.data.last_page,
            res.data.current_page,
            res.data.total
          );
        })
        .catch(err => {
          console.log({ err: err.message });
        });
    },
    page_swap(page = this.pagination_data.page_count.current_page) {
      if (page > this.pagination_data.page_count || page < 1) {
        let page = 1;
      }
      this.load_data(this.cashout_type, page);
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
    delete_cashout(cashout_id) {
      let current_page = this.pagination_data.current_page;
      let cashout_type = this.cashout_type;
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
                `${window.location.origin}/api/admin/cashout/delete/${cashout_id}`
              )
              .then(res => {
                this.load_data(cashout_type, current_page);
                this.$swal.fire({
                  title: `Success: ${res.statusText}`,
                  text: `${res.data.message}`,
                  icon: "success"
                });
                return;
              })
              .catch(err => {
                this.load_data(cashout_type, current_page);
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
