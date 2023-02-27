<template>
  <div class="uk-grid uk-grid-small uk-child-width-1-1" uk-grid>
    <div class="uk-card uk-card-default">
      <div class="uk-card-header uk-padding-small">
        <div
          class="uk-width-expand uk-flex uk-flex-inline uk-flex-between uk-flex-wrap uk-flex-wrap-between"
        >
          <h3 class="uk-card-title uk-margin-remove-bottom uk-text-capitalize">
            {{ investment_status }} Investment
          </h3>
          <ul class="uk-iconnav">
            <li>
              <button
                @click="select_investment('open')"
                class="uk-button uk-button-link"
              >
                <i class="mdi mdi-24px mdi-timelapse grey-text"></i>
              </button>
            </li>
            <li>
              <button
                @click="select_investment('closed')"
                class="uk-button uk-button-link"
              >
                <i class="mdi mdi-24px mdi-check-all  green-text accent-2"></i>
              </button>
            </li>
            <!-- <li>
              <button
                @click="select_investment('fee')"
                class="uk-button uk-button-link"
              >
                <i
                  class="mdi mdi-24px mdi-account-cash  orange-text accent-2"
                ></i>
              </button>
            </li> -->
            <!-- <li>
              <button
                @click="select_investment('expired')"
                class="uk-button uk-button-link"
              >
                <i class="mdi mdi-24px mdi-clock-alert red-text accent-2"></i>
              </button>
            </li> -->
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
              <th class="uk-text-right">Sent</th>
              <th class="uk-text-right">Sending</th>
              <th class="uk-text-right">Avail</th>
              <th class="uk-text-right">User</th>
              <th class="uk-text-right">Time</th>
              <th class="uk-text-right">Type</th>
              <th class="uk-text-right">Status</th>
              <th class="uk-text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(investment, index) in investments"
              :id="`free_investment_${investment.id}`"
              :key="investment.id"
            >
              <td>{{ index + 1 }}</td>
              <td class="uk-text-right">
                {{ Number(investment.total_amount) }}
              </td>
              <td class="uk-text-right">
                {{ Number(investment.sent_amount) }}
              </td>
              <td class="uk-text-right">
                {{ Number(investment.sending_amount) }}
              </td>
              <td class="uk-text-right">
                {{
                  Number(investment.total_amount) -
                    (Number(investment.sent_amount) +
                      Number(investment.sending_amount))
                }}
              </td>
              <td class="uk-text-right">
                {{ investment.sender }}
              </td>
              <td class="uk-text-right">
                {{ investment.time_diff }}
              </td>

              <td class="uk-text-right">
                <span class="uk-label">{{ investment.type }}</span>
              </td>
              <td class="uk-text-right">
                <span
                  v-if="investment.status === 'open'"
                  class="blue-text mdi mdi-18px mdi-pencil-plus"
                  >{{ investment.status }}</span
                >
                <span
                  v-if="investment.status === 'locked'"
                  class="orange-text mdi mdi-18px mdi-circle-outline"
                  >{{ investment.status }}</span
                >
                <span
                  v-if="investment.status === 'failed'"
                  class="red-text mdi mdi-18px mdi-close"
                  >{{ investment.status }}</span
                >
                <span
                  v-if="investment.status === 'confirmed'"
                  class="green-text mdi mdi-18px mdi-check"
                  >{{ investment.status }}</span
                >
                <span
                  v-if="investment.status === 'awaiting_roi'"
                  class="blue-text mdi mdi-18px mdi-timelapse"
                  >{{ investment.status }}</span
                >
                <span
                  v-if="investment.status === 'closed'"
                  class="green-text mdi mdi-18px mdi-check-all"
                  >{{ investment.status }}</span
                >
              </td>
              <td v-show="investment.status === 'open'" class="uk-text-right">
                <button
                  v-if="
                    Math.floor(
                      Number(investment.sent_amount) +
                        Number(investment.sending_amount)
                    ) === 0
                  "
                  @click="delete_investment(investment.id)"
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
      investments: [],
      investment_status: "open",
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
    select_investment(investment) {
      this.investment_status = investment;
      this.load_data(investment, 1);
    },
    load_data(investment_status = "open", page = 1) {
      axios
        .get(
          `${window.location.origin}/api/admin/investment/list/${investment_status}?page=${page}`
        )
        .then(res => {
          this.investments = res.data.data;
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
    page_swap(page = this.pagination_data.current_page) {
      let investment_status = this.investment_status;
      if (page > this.pagination_data.page_count || page < 1) {
        let page = 1;
      }
      this.load_data(investment_status, page);
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
    delete_investment(investment_id) {
      let current_page = this.pagination_data.current_page;
      let investment_status = this.investment_status;
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
                `${window.location.origin}/api/admin/investment/delete/${investment_id}`
              )
              .then(res => {
                this.load_data(investment_status, current_page);
                this.$swal.fire({
                  title: `Success: ${res.statusText}`,
                  text: `${res.data.message}`,
                  icon: "success"
                });
                return;
              })
              .catch(err => {
                this.load_data(investment_status, current_page);
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
