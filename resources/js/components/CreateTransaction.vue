<template>
  <div class="uk-grid uk-grid-collapse uk-grid-match uk-child-width-1-2">
    <div class="">
      <div class="uk-card uk-card-default">
        <div class="uk-card-header uk-padding-small">
          <div class="uk-width-expand">
            <h3 class="uk-card-title uk-margin-remove-bottom">Cashouts</h3>
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
                <th class="uk-text-right">Avail</th>
                <th class="uk-text-right">Time</th>
                <th class="uk-text-right">Reciever</th>
                <th class="uk-text-right">Type</th>
                <th class="uk-text-right">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(cashout, index) in cashouts"
                :id="`free_cashout_${cashout.id}`"
                @click="select_cashout(cashout)"
                :key="cashout.id"
                :class="{ 'blue lighten-3': active_cashout(cashout) }"
              >
                <td>{{ index + 1 }}</td>
                <td class="uk-text-right">
                  {{ Number(cashout.total_amount) }}
                </td>
                <td class="uk-text-right">
                  {{
                    Number(cashout.total_amount) -
                      (Number(cashout.recieved_amount) +
                        Number(cashout.recieving_amount))
                  }}
                </td>
                <td class="uk-text-right">
                  {{ cashout.time_diff }}
                </td>
                <td class="uk-text-right">
                  {{ cashout.reciever }}
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
                    class="orange-text mdi mdi-18px mdi-circle-outline"
                  ></span>
                  <span
                    v-if="cashout.status === 'closed'"
                    class="red-text mdi mdi-18px mdi-close"
                  ></span>
                  <span
                    v-if="cashout.status === 'diabled'"
                    class="grey-text mdi mdi-18px mdi-timelapse"
                  ></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="uk-text-center uk-card-footer">
          <paginate
            v-if="cashout_pagination_data.record_count > 0"
            v-model="cashout_pagination_data.current_page"
            :page-count="cashout_pagination_data.page_count"
            :page-range="3"
            :margin-pages="2"
            :prev-text="'<span uk-pagination-previous></span>'"
            :next-text="'<span uk-pagination-next></span>'"
            :container-class="'uk-pagination uk-flex-center'"
            :active-class="'uk-active'"
            :disable-class="'uk-disabled'"
            :click-handler="cashout_page_swap"
          >
          </paginate>
        </div>
      </div>
    </div>
    <div class="">
      <div class="uk-card uk-card-default">
        <div class="uk-card-header uk-padding-small">
          <div class="uk-width-expand">
            <h3 class="uk-card-title uk-margin-remove-bottom">Investments</h3>
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
                <th class="uk-text-right">Avail</th>
                <th class="uk-text-right">Time</th>
                <th class="uk-text-right">Sender</th>
                <th class="uk-text-right">Type</th>
                <th class="uk-text-right">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(investment, index) in investments"
                :id="`free_investment_${investment.id}`"
                @click="select_investment(investment)"
                :key="investment.id"
                :class="{ 'blue lighten-3': active_investment(investment) }"
              >
                <td>{{ index + 1 }}</td>
                <td class="uk-text-right">
                  {{ Number(investment.total_amount) }}
                </td>
                <td class="uk-text-right">
                  {{
                    Number(investment.total_amount) -
                      (Number(investment.sent_amount) +
                        Number(investment.sending_amount))
                  }}
                </td>
                <td class="uk-text-right">
                  {{ investment.time_diff }}
                </td>
                <td class="uk-text-right">
                  {{ investment.sender }}
                </td>
                <td class="uk-text-right">
                  <span class="uk-label">{{ investment.type }}</span>
                </td>
                <td class="uk-text-right">
                  <span
                    v-if="investment.status === 'open'"
                    class="blue-text mdi mdi-18px mdi-pencil-plus"
                  ></span>
                  <span
                    v-if="investment.status === 'locked'"
                    class="orange-text mdi mdi-18px mdi-circle-outline"
                  ></span>
                  <span
                    v-if="investment.status === 'closed'"
                    class="red-text mdi mdi-18px mdi-close"
                  ></span>
                  <span
                    v-if="investment.status === 'diabled'"
                    class="grey-text mdi mdi-18px mdi-timelapse"
                  ></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="uk-text-center uk-card-footer">
          <paginate
            v-if="investment_pagination_data.record_count > 0"
            v-model="investment_pagination_data.current_page"
            :page-count="investment_pagination_data.page_count"
            :page-range="3"
            :margin-pages="2"
            :prev-text="'<span uk-pagination-previous></span>'"
            :next-text="'<span uk-pagination-next></span>'"
            :container-class="'uk-pagination uk-flex-center'"
            :active-class="'uk-active'"
            :disable-class="'uk-disabled'"
            :click-handler="investment_page_swap"
          >
          </paginate>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      investments: [],
      cashouts: [],
      selected_investment: null,
      selected_cashout: null,
      transaction_data: {
        investment_id: null,
        cashout_id: null,
        transaction_amount: null
      },
      investment_pagination_data: {
        page_count: 0,
        current_page: 1,
        record_count: 0
      },
      cashout_pagination_data: {
        page_count: 0,
        current_page: 1,
        record_count: 0
      }
    };
  },
  created() {
    this.load_cashout_data(1);
    this.load_investment_data(1);
  },
  methods: {
    set_merge_amount(selected_investment, selected_cashout) {
      const axios_config = {
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json"
        }
      };
      let inv_rem_amt =
        Number(selected_investment.total_amount) -
        (Number(selected_investment.sent_amount) +
          Number(selected_investment.sending_amount));
      let csh_rem_amt =
        Number(selected_cashout.total_amount) -
        (Number(selected_cashout.recieved_amount) +
          Number(
            selected_cashout.recieving_amount
              ? selected_cashout.recieving_amount
              : 0
          ));
      let max_amt =
        Number(inv_rem_amt) < Number(csh_rem_amt)
          ? Number(inv_rem_amt)
          : Number(csh_rem_amt);

      this.$swal.fire({
        title: "How much are you merging?",
        icon: "question",
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: "Merge",
        cancelButtonText: "Cancel",
        input: "range",
        inputAttributes: {
          min: 0,
          max: max_amt,
          step: 1
        },
        inputValue: 0,
        showLoaderOnConfirm: true,
        preConfirm: merge_amount => {
          let trnx_data = {
            investment_id: selected_investment.id,
            cashout_id: selected_cashout.id,
            transaction_amount: merge_amount
          };
         return axios
            .post(
              `${window.location.origin}/api/admin/transaction/create`,
              trnx_data,
              axios_config
            )
            .then(res => {
              this.cashout_page_swap(this.cashout_pagination_data.current_page);
              this.investment_page_swap(
                this.investment_pagination_data.current_page
              );
              this.$swal.fire({
                title: "Successful" + `: ${res.statusText}`,
                icon: "success",
                text: `${res.data.message}`
              });
            })
            .catch(err => {
              this.cashout_page_swap(this.cashout_pagination_data.current_page);
              this.investment_page_swap(
                this.investment_pagination_data.current_page
              );
              this.$swal.fire({
                title: "Failed: " + `${err.response.statusText}`,
                icon: "error",
                text: `${err.response.data.message}`
              });
            });
        }
      });
    },
    select_cashout(cashout) {
      this.selected_cashout = cashout;
    },
    select_investment(investment) {
      this.selected_investment = investment;
      this.set_merge_amount(this.selected_investment, this.selected_cashout);
    },
    load_cashout_data(page = 1) {
      this.selected_cashout = null;
      this.selected_investment = null;
      this.transaction_data.investment_id = null;
      this.transaction_data.cashout_id = null;
      this.transaction_data.transaction_amount = null;
      axios
        .get(`${window.location.origin}/api/admin/cashout/list?page=${page}`)
        .then(res => {
          this.cashouts = res.data.data;
          this.load_cashout_pagination_data(
            res.data.last_page,
            res.data.current_page,
            res.data.total
          );
        });
    },
    load_investment_data(page = 1) {
      this.selected_cashout = null;
      this.selected_investment = null;
      this.transaction_data.investment_id = null;
      this.transaction_data.cashout_id = null;
      this.transaction_data.transaction_amount = null;
      axios
        .get(`${window.location.origin}/api/admin/investment/list?page=${page}`)
        .then(res => {
          this.investments = res.data.data;
          this.load_investment_pagination_data(
            res.data.last_page,
            res.data.current_page,
            res.data.total
          );
        });
    },
    active_cashout(cashout) {
      if (this.selected_cashout) {
        if (this.selected_cashout.id == cashout.id) {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    },
    active_investment(investment) {
      if (this.selected_investment) {
        if (this.selected_investment.id == investment.id) {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    },
    cashout_page_swap(page = this.cashout_pagination_data.current_page) {
      if (page > this.cashout_pagination_data.page_count || page < 1) {
        let page = 1;
      }
      this.load_cashout_data(page);
      return;
    },
    load_cashout_pagination_data(last_page, current_page, total_records) {
      this.cashout_pagination_data = {
        page_count: last_page,
        current_page: current_page,
        record_count: total_records
      };
      return;
    },
    investment_page_swap(page = this.investment_pagination_data.current_page) {
      if (page > this.investment_pagination_data.page_count || page < 1) {
        let page = 1;
      }
      this.load_investment_data(page);
      return;
    },
    load_investment_pagination_data(last_page, current_page, total_records) {
      this.investment_pagination_data = {
        page_count: last_page,
        current_page: current_page,
        record_count: total_records
      };
      return;
    }
  }
};
</script>
<style scoped>
tr:hover {
  cursor: pointer;
}
</style>
