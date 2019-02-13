<template>
  <div>
    
    <main class="main">
      <div class="main-body">
        <div class="notification is-danger" style="margin-top: 1.5rem" v-if="errMsg">
          <a :href="errMsgLink" v-text="errMsg"></a>
        </div>
        <ul class="main-list-ul" v-else>
          <li class="main-list-li" v-for="item in searchDownList">
            <article class="main-card">
              <div class="main-card-body">
                <div class="main-card-header">
                  <div class="main-card-icon">
                    <img class="main-card-icon-img" :src="'/' + item.icon_path" alt="软件图标">
                  </div>
                  <h1 class="main-card-title" v-text="item.name"></h1>
                </div>
                <div class="main-card-content">
                  <p class="main-card-content-text" v-text="item.description"></p>
                </div>
                <div class="main-card-footer">
                  <p class="main-card-footer-version">
                    <span v-if="item.winFile">Win: {{ item.winFile.version }}</span>
                    <span v-if="item.macFile">Mac: {{ item.macFile.version }}</span>
                  </p>
                  <div class="main-card-footer-button-group">
                    <a
                      class="main-card-footer-button"
                      :href="'/download/' + item.id + '/win?t=' + Date.now()"
                      :title="readableSize(item.winFile.size)"
                      v-if="item.winFile"
                    >
                      <img
                        class="main-card-footer-button-icon win"
                        src="/static/index/images/win.png"
                        alt="WIN版本"
                      >
                      <span class="main-card-footer-button-text">WIN版本</span>
                    </a>
                    <a
                      class="main-card-footer-button"
                      :href="'/download/' + item.id + '/mac?t=' + Date.now()"
                      :title="readableSize(item.macFile.size)"
                      v-if="item.macFile"
                    >
                      <img
                        class="main-card-footer-button-icon mac"
                        src="/static/index/images/mac.png"
                        alt="MAC版本"
                      >
                      <span class="main-card-footer-button-text">MAC版本</span>
                    </a>
                  </div>
                </div>
              </div>
            </article>
          </li>
        </ul>
      </div>
    </main>

    <footer class="my-footer">
      <div class="my-footer-box" @click="showModal">如果有其他需要的软件，点击这里向我们反馈</div>
    </footer>
    <div class="modal" :class="{'is-active': isModalShow}">
      <div class="modal-background" @click="hideModal"></div>
      <div class="modal-content">
        <div class="box">
          <div class="field is-horizontal">
            <div class="field-label is-normal">
              <label class="label">反馈内容</label>
            </div>
            <div class="field-body">
              <div class="field">
                <div class="control">
                  <textarea class="textarea" v-model="content"></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="field is-horizontal">
            <div class="field-label is-normal">
              <label class="label">您的称呼</label>
            </div>
            <div class="field-body">
              <div class="field">
                <div class="control">
                  <input class="input" type="text" placeholder="(选填)" v-model="name">
                </div>
              </div>
            </div>
          </div>
          <div class="field is-horizontal">
            <div class="field-label is-normal">
              <label class="label">您的联系方式</label>
            </div>
            <div class="field-body">
              <div class="field">
                <div class="control">
                  <input class="input" type="text" placeholder="(选填，邮箱、电话、QQ均可)" v-model="contact">
                </div>
              </div>
            </div>
          </div>
          <div class="field is-horizontal">
            <div class="field-label">
              <!-- Left empty for spacing -->
            </div>
            <div class="field-body">
              <div class="field">
                <div class="control">
                  <!-- <a class="button is-success" @click="saveIssue">
                    <span>提交</span>
                  </a>-->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button class="modal-close" @click="hideModal"></button>
    </div>
  </div>
</template>
<script>
export default {
  name: "example",
  data() {
    return {
      search: "",
      downList: [],
      errMsg: "",
      errMsgLink: "",
      content: "",
      name: "",
      contact: "",
      isModalShow: false,
    };
  },
  mounted: function() {
    this.getList();
  },
  computed: {
    searchDownList: function() {
      var searchRegExp = new RegExp(this.search, "i");
      var result = [];
      for (var i = 0; i < this.downList.length; i++) {
        var item = this.downList[i];
        if (
          item.name.match(searchRegExp) ||
          item.description.match(searchRegExp)
        ) {
          result.push(item);
        }
      }
      return result;
    }
  },
  methods: {
    getList: function() {
      axios({
        method: "get",
        url: "/api/items",
        headers: { "x-Requested-With": "XMLHttpRequest" }
      }).then(response=>{
        this.downList = response.data.data;
      });
    },
    // saveIssue: function() {
    //   axios({
    //     method: "post",
    //     url: "/api/comments/",
    //     data: {
    //       content: data.content,
    //       name: data.name,
    //       contact: data.contact
    //     }
    //   }).then(function(response) {
    //     alert(response.data.msg);
    //     if (response.data.code === 200) {
    //       vm.hideModal();
    //     }
    //   });
    // },
    showModal: function() {
      this.isModalShow = true;
    },
    hideModal: function() {
      this.isModalShow = false;
    },
    readableSize: function(bytes) {
      if (bytes < 1024) {
        return bytes + "B";
      }
      if (bytes < 1048576) {
        return Math.round((10 * bytes) / 1024) / 10 + "K";
      }
      if (bytes < 1073741824) {
        return Math.round((10 * bytes) / 1048576) / 10 + "M";
      }
      return Math.round((10 * bytes) / 1073741824) / 10 + "G";
    },
    // Improvelist:function(){
    //     for (let i = 0; i < this.downList.length; i++) {
    //         const item = this.downList[i];
            
    //     }
    // },
  }
};
</script>