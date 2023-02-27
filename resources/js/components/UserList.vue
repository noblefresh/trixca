<template>
  <div class="uk-grid uk-grid-small uk-child-width-1-1" uk-grid>
    <div class="uk-card uk-card-default">
      <div class="uk-card-header uk-padding-small">
        <div
          class="uk-width-expand uk-flex uk-flex-inline uk-flex-between uk-flex-wrap uk-flex-wrap-between"
        >
          <h3 class="uk-card-title uk-margin-remove-bottom uk-text-capitalize">
            {{ user_status }} User
          </h3>
          <ul class="uk-iconnav">
            <li>
              <button
                @click="find_block_user()"
                class="uk-button uk-button-link"
              >
                <i
                  class="mdi mdi-24px mdi-account-minus red-text text-accent-2"
                ></i>
              </button>
            </li>
            <li>
              <button
                @click="find_unblock_user()"
                class="uk-button uk-button-link"
              >
                <i
                  class="mdi mdi-24px mdi-account-plus green-text text-accent-2"
                ></i>
              </button>
            </li>
            <li>
              <button
                @click="find_sanction_user()"
                class="uk-button uk-button-link"
              >
                <i
                  class="mdi mdi-24px mdi-magnify green-text text-accent-2"
                ></i>
              </button>
            </li>
            <li>
              <button
                @click="load_data('active')"
                class="uk-button uk-button-link"
              >
                <i
                  class="mdi mdi-24px mdi-account-multiple blue-text text-accent-2"
                ></i>
              </button>
            </li>
            <li>
              <button
                @click="load_data('blocked')"
                class="uk-button uk-button-link"
              >
                <i
                  class="mdi mdi-24px mdi-account-multiple-remove red-text text-accent-2"
                ></i>
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
              <th class="uk-text-right">Name</th>
              <th class="uk-text-right">Username</th>
              <th class="uk-text-right">Phone</th>
              <th class="uk-text-right">Country</th>
              <th class="uk-text-right">Joined</th>
              <th v-if="user_status == 'blocked'" class="uk-text-right">
                Blocked
              </th>
              <th class="uk-text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(user, index) in users"
              :id="`user_${user.id}`"
              :key="user.id"
            >
              <td>{{ index + 1 }}</td>
              <td class="uk-text-right">{{ user.full_name }}</td>
              <td class="uk-text-right">{{ user.username }}</td>
              <td class="uk-text-right">{{ user.phone }}</td>
              <td class="uk-text-right">
                {{ user.country }}
              </td>
              <td class="uk-text-right">
                {{ user.time_diff }}
              </td>
              <td v-if="user_status == 'blocked'" class="uk-text-right">
                {{ user.blocked_diff }}
              </td>
              <td class="uk-text-right">
                <div class="uk-button-group">
                  <button
                    @click="view_user(user.id)"
                    class="uk-button uk-button-small"
                  >
                    <i
                      class="mdi mdi-24px mdi-account-details blue-text text-accent-2"
                    ></i>
                  </button>
                  <button
                    v-if="user_status == 'active'"
                    @click="block_user(user.id)"
                    class="uk-button uk-button-small"
                  >
                    <i
                      class="mdi mdi-24px mdi-account-off red-text text-accent-2"
                    ></i>
                  </button>
                  <button
                    v-if="user_status == 'blocked'"
                    @click="unblock_user(user.id)"
                    class="uk-button uk-button-small"
                  >
                    <i
                      class="mdi mdi-24px mdi-account-check green-text text-accent-2"
                    ></i>
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
      users: [],
      selected_user: null,
      user_status: "active",
      pagination_data: {
        page_count: 0,
        current_page: 1,
        record_count: 0
      }
    };
  },
  created() {
    this.load_data("active", 1);
  },
  methods: {
    penalize_user(user) {
      this.selected_user = user;
    },
    load_data(user_status, page = 1) {
      this.user_status = user_status;
      axios
        .get(
          `${window.location.origin}/api/admin/user/list/${user_status}?page=${page}`
        )
        .then(res => {
          this.users = res.data.data;
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
      this.load_data(this.user_status, page);
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
    view_user(user_id) {
      axios
        .get(`${window.location.origin}/api/admin/user/find/by/id/${user_id}`)
        .then(res => {
          let user_details = "";
          Object.keys(res.data.user).map(function(key) {
            user_details += `<li class="uk-padding-remove">
            <div class="uk-grid-small uk-margin-small-top uk-text-center uk-grid-match" uk-grid>
              <div class=" uk-width-2-5">
                <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                  <div class="uk-width-expand">
                    <h5 class="uk-text-bold">${key}: </h5>
                  </div>
                </div>
              </div>
              <div class="uk-width-3-5">
                <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                  <div class="uk-width-expand">
                    <h5>${res.data.user[key]}</h5>
                  </div>
                </div>
              </div>
            </div>
          </li>`;
          });
          this.$swal.fire({
            showCloseButton: true,
            confirmButtonText: "Ok",
            title: "User Details",
            html: `<ul id='user_details' class='uk-list uk-list-divider uk-margin-remove'>${user_details}</ul>`
          });
        })
        .catch(err => {
          console.log({ err: err.message });
        });
    },
    find_sanction_user() {
      this.$swal.fire({
        title: "Find User",
        input: "text",
        confirmButtonText: "Find",
        cancelButtonText: "Cancel",
        showCloseButton: true,
        showCancelButton: true,
        inputValidator: value => {
          if (!value) {
            return "You need to write something!";
          }
        },
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !this.$swal.isLoading(),
        preConfirm: value => {
          return axios
            .get(
              `${window.location.origin}/api/admin/user/find/by/username/${value}`
            )
            .then(res => {
              let user_details = "";
              Object.keys(res.data.user).map(function(key) {
                user_details += `<li class="uk-padding-remove">
          <div class="uk-grid-small uk-margin-small-top uk-text-center uk-grid-match" uk-grid>
            <div class=" uk-width-2-5">
              <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                <div class="uk-width-expand">
                  <h5 class="uk-text-bold">${key}: </h5>
                </div>
              </div>
            </div>
            <div class="uk-width-3-5">
              <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                <div class="uk-width-expand">
                  <h5>${res.data.user[key]}</h5>
                </div>
              </div>
            </div>
          </div>
        </li>`;
              });
              this.$swal
                .fire({
                  showCloseButton: true,
                  showCancelButton: true,
                  confirmButtonText: "Close",
                  cancelButtonText: "Sanction User",
                  reverseButtons: true,
                  title: "User Details",
                  html: `<ul id='user_details' class='uk-list uk-list-divider uk-margin-remove'>${user_details}</ul>`
                })
                .then(result => {
                  if (
                    /* Read more about handling dismissals below */
                    result.dismiss === "cancel"
                  ) {
                    this.$swal.fire({
                      title: "Sanction User!",
                      text: "5% will be deducted from user next cashout",
                      icon: "error",
                      showCancelButton: true,
                      showCloseButton: true,
                      confirmButtonText: "Yes Sanction",
                      cancelButtonText: "No Cancel",
                      reverseButtons: true,
                      allowOutsideClick: () => !this.$swal.isLoading(),
                      preConfirm: () => {
                        return axios
                          .get(
                            `${window.location.origin}/api/admin/user/sanction/${value}`
                          )
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
                          });
                      }
                    });
                  }
                });
            })
            .catch(err => {
              console.log({ err: err.message });
              this.$swal.fire({
                title: "Failed: " + `${err.response.statusText}`,
                icon: "error",
                text: `${err.response.data.message}`
              });
            });
        }
      });
    },
    find_block_user() {
      this.$swal.fire({
        title: "Find User",
        input: "text",
        confirmButtonText: "Find",
        cancelButtonText: "Cancel",
        showCloseButton: true,
        showCancelButton: true,
        inputValidator: value => {
          if (!value) {
            return "You need to write something!";
          }
        },
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !this.$swal.isLoading(),
        preConfirm: value => {
          return axios
            .get(
              `${window.location.origin}/api/admin/user/find/by/username/${value}`
            )
            .then(res => {
              let user_details = "";
              Object.keys(res.data.user).map(function(key) {
                user_details += `<li class="uk-padding-remove">
          <div class="uk-grid-small uk-margin-small-top uk-text-center uk-grid-match" uk-grid>
            <div class=" uk-width-2-5">
              <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                <div class="uk-width-expand">
                  <h5 class="uk-text-bold">${key}: </h5>
                </div>
              </div>
            </div>
            <div class="uk-width-3-5">
              <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                <div class="uk-width-expand">
                  <h5>${res.data.user[key]}</h5>
                </div>
              </div>
            </div>
          </div>
        </li>`;
              });
              this.$swal
                .fire({
                  showCloseButton: true,
                  showCancelButton: true,
                  confirmButtonText: "Close",
                  cancelButtonText: "Block User",
                  reverseButtons: true,
                  title: "User Details",
                  html: `<ul id='user_details' class='uk-list uk-list-divider uk-margin-remove'>${user_details}</ul>`
                })
                .then(result => {
                  if (
                    /* Read more about handling dismissals below */
                    result.dismiss === "cancel"
                  ) {
                    this.$swal.fire({
                      title: "Block User!",
                      text: "User account will be Blocked",
                      icon: "error",
                      showCancelButton: true,
                      showCloseButton: true,
                      confirmButtonText: "Yes Sanction",
                      cancelButtonText: "No Cancel",
                      reverseButtons: true,
                      allowOutsideClick: () => !this.$swal.isLoading(),
                      preConfirm: () => {
                        return axios
                          .get(
                            `${window.location.origin}/api/admin/user/block/${value}`
                          )
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
                          });
                      }
                    });
                  }
                });
            })
            .catch(err => {
              console.log({ err: err.message });
              this.$swal.fire({
                title: "Failed: " + `${err.response.statusText}`,
                icon: "error",
                text: `${err.response.data.message}`
              });
            });
        }
      });
    },
    find_unblock_user() {
      this.$swal.fire({
        title: "Find User",
        input: "text",
        confirmButtonText: "Find",
        cancelButtonText: "Cancel",
        showCloseButton: true,
        showCancelButton: true,
        inputValidator: value => {
          if (!value) {
            return "You need to write something!";
          }
        },
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !this.$swal.isLoading(),
        preConfirm: value => {
          return axios
            .get(
              `${window.location.origin}/api/admin/user/find/by/username/${value}`
            )
            .then(res => {
              let user_details = "";
              Object.keys(res.data.user).map(function(key) {
                user_details += `<li class="uk-padding-remove">
          <div class="uk-grid-small uk-margin-small-top uk-text-center uk-grid-match" uk-grid>
            <div class=" uk-width-2-5">
              <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                <div class="uk-width-expand">
                  <h5 class="uk-text-bold">${key}: </h5>
                </div>
              </div>
            </div>
            <div class="uk-width-3-5">
              <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                <div class="uk-width-expand">
                  <h5>${res.data.user[key]}</h5>
                </div>
              </div>
            </div>
          </div>
        </li>`;
              });
              this.$swal
                .fire({
                  showCloseButton: true,
                  showCancelButton: true,
                  confirmButtonText: "Close",
                  cancelButtonText: "Unblock User",
                  reverseButtons: true,
                  title: "User Details",
                  html: `<ul id='user_details' class='uk-list uk-list-divider uk-margin-remove'>${user_details}</ul>`
                })
                .then(result => {
                  if (
                    /* Read more about handling dismissals below */
                    result.dismiss === "cancel"
                  ) {
                    this.$swal.fire({
                      title: "Block User!",
                      text: "User account will be UnBlocked",
                      icon: "success",
                      showCancelButton: true,
                      showCloseButton: true,
                      confirmButtonText: "Yes Unblock",
                      cancelButtonText: "No Cancel",
                      reverseButtons: true,
                      allowOutsideClick: () => !this.$swal.isLoading(),
                      preConfirm: () => {
                        return axios
                          .get(
                            `${window.location.origin}/api/admin/user/unblock/${value}`
                          )
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
                          });
                      }
                    });
                  }
                });
            })
            .catch(err => {
              console.log({ err: err.message });
              this.$swal.fire({
                title: "Failed: " + `${err.response.statusText}`,
                icon: "error",
                text: `${err.response.data.message}`
              });
            });
        }
      });
    },
    block_user(user_id) {
      let current_status = this.user_status;
      let current_page = this.pagination_data.current_page;
      this.$swal.fire({
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: "Block User",
        cancelButtonText: "Close",
        reverseButtons: true,
        icon: "error",
        title: "Continue",
        text: "Block This Account",
        allowOutsideClick: () => !this.$swal.isLoading(),
        preConfirm: () => {
          this.$swal.fire({
            title: "Block User!",
            text: "User account will be Blocked",
            icon: "error",
            showCancelButton: true,
            showCloseButton: true,
            confirmButtonText: "Yes block",
            cancelButtonText: "No Cancel",
            reverseButtons: true,
            allowOutsideClick: () => !this.$swal.isLoading(),
            preConfirm: () => {
              return axios
                .get(`${window.location.origin}/api/admin/user/block/${user_id}`)
                .then(res => {
                  this.load_data(current_status, current_page);
                  this.$swal.fire({
                    title: "Successful" + `: ${res.statusText}`,
                    icon: "success",
                    text: `${res.data.message}`
                  });
                })
                .catch(err => {
                  this.load_data(current_status, current_page);
                  this.$swal.fire({
                    title: "Failed: " + `${err.response.statusText}`,
                    icon: "error",
                    text: `${err.response.data.message}`
                  });
                });
            }
          });
        }
      });
    },
    unblock_user(user_id) {
      let current_status = this.user_status;
      let current_page = this.pagination_data.current_page;
      this.$swal.fire({
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: "UnBlock User",
        cancelButtonText: "Close",
        reverseButtons: true,
        icon: "info",
        title: "Continue",
        text: "UnBlock This Account",
        allowOutsideClick: () => !this.$swal.isLoading(),
        preConfirm: () => {
          this.$swal.fire({
            title: "Block User!",
            text: "User account will be unBlocked",
            icon: "info",
            showCancelButton: true,
            showCloseButton: true,
            confirmButtonText: "Yes Unblock",
            cancelButtonText: "No Cancel",
            reverseButtons: true,
            allowOutsideClick: () => !this.$swal.isLoading(),
            preConfirm: () => {
              return axios
                .get(
                  `${window.location.origin}/api/admin/user/unblock/${user_id}`
                )
                .then(res => {
                  this.load_data(current_status, current_page);
                  this.$swal.fire({
                    title: "Successful" + `: ${res.statusText}`,
                    icon: "success",
                    text: `${res.data.message}`
                  });
                })
                .catch(err => {
                  this.load_data(current_status, current_page);
                  this.$swal.fire({
                    title: "Failed: " + `${err.response.statusText}`,
                    icon: "error",
                    text: `${err.response.data.message}`
                  });
                });
            }
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
