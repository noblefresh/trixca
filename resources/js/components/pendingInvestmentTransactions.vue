<template>
  <div>
    <div class="uk-card-header">
      <div class="uk-width-expand">
        <h3
          class="uk-card-title uk-margin-remove-bottom uk-text-bold uk-text-center"
        >
          {{ trans.get("pendingInvestmentTransaction.title") }}
        </h3>
      </div>
    </div>
    <div class="uk-card-body uk-padding-small">
      <ul uk-accordion="multiple: true">
        <li
          v-for="(transaction, index) in transactions"
          :id="`invt_trnx._${transaction.id}`"
          :key="`invt_trnx_${index}`"
          :class="['uk-open', 'blue']"
        >
          <template>
            <a class="uk-accordion-title uk-padding-small white-text" href="#">
              <i class="mdi mdi-arrow-up red-text"></i>
              <div
                class="uk-grid-small uk-child-width-auto uk-flex-inline"
                uk-grid
                :uk-countdown="`date: ${transaction.count_down}`"
              >
                <div class="uk-text-small">
                  <div
                    class="uk-countdown-days uk-text-center uk-text-bold"
                  ></div>
                  <div
                    class="uk-countdown-label uk-margin-remove-top uk-margin-small uk-text-center uk-visible@s"
                  >
                    {{ trans.get("pendingInvestmentTransaction.days") }}
                  </div>
                </div>
                <div
                  class="uk-countdown-separator uk-text-small"
                  style="padding-left:5px;"
                >
                  :
                </div>
                <div class="uk-text-small" style="padding-left:5px;">
                  <div
                    class="uk-countdown-hours uk-text-center uk-text-bold"
                  ></div>
                  <div
                    class="uk-countdown-label uk-margin-remove-top uk-margin-small uk-text-center uk-visible@s"
                  >
                    {{ trans.get("pendingInvestmentTransaction.hours") }}
                  </div>
                </div>
                <div
                  class="uk-countdown-separator uk-text-small"
                  style="padding-left:5px;"
                >
                  :
                </div>
                <div class="uk-text-small" style="padding-left:5px;">
                  <div
                    class="uk-countdown-minutes uk-text-center uk-text-bold"
                  ></div>
                  <div
                    class="uk-countdown-label uk-margin-remove-top uk-margin-small uk-text-center uk-visible@s"
                  >
                    {{ trans.get("pendingInvestmentTransaction.minutes") }}
                  </div>
                </div>
                <div
                  class="uk-countdown-separator uk-text-small"
                  style="padding-left:5px;"
                >
                  :
                </div>
                <div class="uk-text-small" style="padding-left:5px;">
                  <div
                    class="uk-countdown-seconds uk-text-center uk-text-bold"
                  ></div>
                  <div
                    class="uk-countdown-label uk-margin-remove-top uk-margin-small uk-text-center uk-visible@s"
                  >
                    {{ trans.get("pendingInvestmentTransaction.seconds") }}
                  </div>
                </div>
              </div>
              <span class="uk-label uk-label-danger uk-float-right">{{
                Number(transaction.amount)
              }}</span>
            </a>
            <div
              class="uk-accordion-content uk-padding-small uk-padding-remove-top"
            >
              <div class="uk-text-center">
                <div
                  class="uk-button-group uk-flex uk-flex-center uk-flex-middle"
                >
                  <button
                    title="View Receiver Details"
                    class="uk-button uk-button-medium white lighten-3 blue-text"
                    @click="view_reciever(transaction.id)"
                  >
                    <span class="mdi mdi-18px mdi-account"></span> {{ trans.get("pendingInvestmentTransaction.receiver") }}
                  </button>
                  <button
                    v-if="transaction.pop == null"
                    @click="submit_pop(transaction.id)"
                    :id="`spop_${transaction.type}_${transaction.id}`"
                    title="submit proof of payment"
                    class="uk-button uk-button-medium white lighten-3 blue-text"
                  >
                    <span class="mdi mdi-18px mdi-image"></span> POP
                  </button>
                  <button
                    v-else
                    title="View Proof of payment"
                    class="uk-button uk-button-medium white lighten-3 blue-text"
                    @click="view_pop(transaction.pop)"
                    :id="`vpop_${transaction.type}_${transaction.id}`"
                  >
                    <span class="mdi mdi-18px mdi-image"></span>POP
                  </button>
                </div>
              </div>
            </div>
          </template>
        </li>
      </ul>
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
</template>
<script>
export default {
  data() {
    return {
      pagination_data: {
        page_count: 0,
        current_page: 1,
        record_count: 0
      },
      transactions: []
    };
  },
  methods: {
    load_data(page = null) {
      let api_url = "";
      if (page == null) {
        api_url = `${window.location.origin}/api/user/transaction/investment_list/${Laravel.userId}`;
      } else {
        api_url = page;
      }
      axios
        .get(api_url)
        .then(res => {
          this.load_transactions_data(res.data.transactions.data);
          this.load_pagination_data(
            res.data.transactions.last_page,
            res.data.transactions.current_page,
            res.data.transactions.total
          );
          return;
        })
        .catch(err => {
          console.log({ err: err.message });
        });
    },
    load_transactions_data(data) {
      this.transactions = data;
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
    page_swap(page = this.pagination_data.current_page) {
      if (page > this.pagination_data.page_count || page < 1) {
        let page = 1;
      }
      this.load_data(
        `${window.location.origin}/api/user/transaction/investment_list/${Laravel.userId}?page=${page}`
      );
      return;
    },
    submit_pop(transaction_id) {
      let selected_transaction = transaction_id;
      this.$swal.fire({
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: "Select",
        cancelButtonText: "Cancel",
        title: "Select POP",
        html:
          "<img data-src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAPoAAAD6BAMAAAB6wkcOAAAAG1BMVEXMzMyWlpacnJyjo6Oqqqq3t7fFxcWxsbG+vr6BtizEAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAC8ElEQVR42u2ZTXPSQBiAI1DgaCwUjwXHj2M5aHtsDjoe0TqOR6hfPcrUH1BGx98tJJsQkndDaN5dPTzPhWSXN0+y2e8EAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/K/0f07CyfnM2fUfhFuevC5k/jYZF3UDmtjDcDDP573P0l/UC2hoD0e5rM+59Fd1Ahrbw8vtO88nP7rbH6BgP85yljvpw/0BCvbwh8noFdJn+wLua5/EjJOLPTYZ7+Kz55/mN1c76daA+9rNYfdDriSTt/42Pv4eH8+rA5rag+DL5mpJ/brON7T45LQ6oLk9rmlJJY42jTlLj7ZtyxagYO+szx5mBX+5k26K3hKgYe+mtahdeKHT7GYsARr2jSUu4dU6+SyXfp1ZLAEq9qV55GmhNvWzamAJULGvkot1d+pcejsVATr2xbpLX/8crVNPdv63SLs7OUDHbk7bpYbUSSuCHKBqX5Q6kX5aGi7tpiCX5fIcm3HOZcmbi0XldhSZeujSbqrwuNyHrIzGZZ1fxk/YFfrP9I9igJI9ebv97ZCW0TIVUQzQsZua3RNGro6ZxogBOvZW8tAdYcKU3pEYoGOfJtq2MGfom+5GDFCx/zLDuM1+agtQsN/chmZwaQnX7Jbt2wC1GfVJDXspQM0+s3TeaR8gBmjZB9ahw2JvUvDysuyQZ9dcxw2zVlzzvQ8DPbtZjte3K67fs62Ifb2N6t5FKbF+X+fC3hEaktzPu7DXH+Nc2A8Y3x3YbXObuRf7AfM6F3ZhTrus6oV17fJ8fuTJXn8t48Jefx3nwl5/DevCXl6/R+nA48Eu7l0cB77sq0Jv17Lt2zixS3tWZ97s0n7dnTe7sFc5CPzZ463ZZ/v2aV3Zkz3qN/FxvBecNgEvdrM/f/7nW7Jeyiavfuw9yycIP/bCd5lR4Nd+JK/WPNkrvsf5sOe+RT4N3NgruTLyl8E/4evt5hv0xwAAAAAAAAAAAAAAAAAAAAAAAAAAAADgUP4CYVaZeUH9jw4AAAAASUVORK5CYII=' width='400' height='200' alt='pop placeholder' style='height:40vh;object-fit:cover;' class='uk-width-1-1 uk-border-rounded' uk-img>",
        input: "file",
        inputAttributes: {
          accept: "image/*",
          "aria-label": "Upload your proof of payment picture"
        },
        preConfirm: file => {
          let file_obj = file;
          this.$swal.fire({
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: "Upload",
            cancelButtonText: "Cancel",
            title: "Upload POP",
            html: `<img data-src='${URL.createObjectURL(
              file
            )}' width='400' height='200' alt='selected pop image' style='height:40vh;object-fit:cover;' class='uk-width-1-1 uk-border-rounded' uk-img>`,
            showLoaderOnConfirm: true,
            preConfirm: () => {
              let pop_form = new FormData();
              pop_form.append("user_id", Laravel.userId);
              pop_form.append("pop_image", file_obj);
              pop_form.append("transaction_id", selected_transaction);
              const pop_submit_url = `${window.location.origin}/api/user/transaction/pop/upload`;
              const axios_config = {
                headers: {
                  "Content-Type": "multipart/form-data",
                  Accept: "application/json"
                }
              };
              axios
                .post(pop_submit_url, pop_form, axios_config)
                .then(res => {
                  this.$swal.fire({
                    title: "Successful" + `: ${res.statusText}`,
                    icon: "success",
                    text: `${res.data.message}`
                  });
                })
                .catch(err => {
                  this.$swal.fire({
                    title: "Failed: " + `${err.response.statusText}`,
                    icon: "error",
                    text: `${err.response.data.message}`
                  });
                })
                .finally(() => {
                  this.load_data();
                });
            }
          });
        }
      });
    },
    view_pop(param) {
      let pop = param;
      this.$swal.fire({
        showCloseButton: true,
        confirmButtonText: "Ok",
        title: "Viewing POP",
        html: `<img data-src='${window.location.origin}/image/pop/${pop}' width='400' height='200' alt='pop placeholder' style='height:50vh;object-fit:cover;' class='uk-width-1-1 uk-border-rounded' uk-img>`,
        onDestroy: () => {
          pop = null;
        }
      });
    },
    view_reciever(transaction_id) {
      axios
        .get(
          `${window.location.origin}/api/user/transaction/find/${transaction_id}/reciever`
        )
        .then(res => {
          let reciever_details = "";
          Object.keys(res.data.reciever).map(function(key) {
            reciever_details += `<li class="uk-padding-remove">
            <div class="uk-grid-small uk-child-width-1-2 uk-margin-small-top uk-text-center uk-grid-match" uk-grid>
              <div>
                <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                  <div class="uk-width-expand">
                    <h5 class="uk-text-bold">${key}: </h5>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                  <div class="uk-width-expand">
                    <h5>${res.data.reciever[key]}</h5>
                  </div>
                </div>
              </div>
            </div>
          </li>`;
          });
          this.$swal.fire({
            showCloseButton: true,
            confirmButtonText: "Ok",
            title: "Reciever Details",
            html: `<ul id='receiver_details' class='uk-list uk-list-divider'>${reciever_details}'</ul>`
          });
        })
        .catch(err => {
          console.log({ err: err.message });
        });
    }
  },
  created() {
    this.load_data();
  }
};
</script>
