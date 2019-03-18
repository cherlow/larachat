<template>
  <div
    class="card direct-chat direct-chat-primary"
    style="position: relative; left: 0px; top: 0px;"
  >
    <div class="card-header">
      <h3 class="card-title">Chat {{ouser.name}}</h3>

      <div class="card-tools">
        <span
          v-if="usertyping"
          data-toggle="tooltip"
          title="3 New Messages"
          class="lara-green"
        >user typing...</span>

        <button @click.prevent="hidechat" type="button" class="btn btn-tool">
          <i class="fa fa-times"></i>
        </button>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <!-- Conversations are loaded here -->
      <div class="direct-chat-messages" v-chat-scroll>
        <!-- Message. Default to the left -->
        <div v-for="message in messages" :key="message.id">
          <div class="direct-chat-msg" v-if="message.messenger_id == auth.id">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name float-left">{{auth.name}}</span>
              <span class="direct-chat-timestamp float-right">{{message.created_at | mydate}}</span>
            </div>
            <!-- /.direct-chat-info -->
            <img
              class="direct-chat-img"
              src="../../../public/img/user.png"
              alt="message user image"
            >
            <!-- /.direct-chat-img -->
            <div class="direct-chat-text">{{message.message}}</div>
            <!-- /.direct-chat-text -->
          </div>
          <!-- /.direct-chat-msg -->
          <!-- Message to the right -->
          <div class="direct-chat-msg right" v-else>
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name float-right">{{ouser.name}}</span>
              <span class="direct-chat-timestamp float-left">{{message.created_at | mydate}}</span>
            </div>
            <!-- /.direct-chat-info -->
            <img
              class="direct-chat-img"
              src="../../../public/img/user.png"
              alt="message user image"
            >
            <!-- /.direct-chat-img -->
            <div class="direct-chat-text">{{message.message}}</div>
            <!-- /.direct-chat-text -->
          </div>
        </div>
        <!-- /.direct-chat-msg -->
      </div>
      <!--/.direct-chat-messages-->
      <!-- Contacts are loaded here -->
      <!-- /.direct-chat-pane -->
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div class="input-group">
        <input
          @keydown="sendTypingEvent"
          autocomplete="off"
          @keyup.enter.prevent="sendmessage"
          v-model="message"
          type="text"
          name="message"
          placeholder="Type Message ..."
          class="form-control"
          autofocus="true"
        >
        <span class="input-group-append">
          <button type="button" class="btn btn-primary" @click="sendmessage">Send</button>
        </span>
      </div>
    </div>
    <!-- /.card-footer-->
  </div>
</template>

<script>
export default {
  data() {
    return {
      messages: {},
      ouser: [],
      auth: [],
      message: "",

      usertyping: false,
      typingtimer: false
    };
  },
  props: ["user"],
  created() {

    axios.get("/userauth").then(response => {
      this.auth = response.data;

      // listen for events

      window.Echo.private("pmessage_" + this.auth.id)
        .listen("SendMessage", event => {
          this.getmessages(this.user);
        })
        .listenForWhisper("typing", response => {
          if (response == this.user) {
            this.usertyping = true;

            if (this.typingtimer) {
              clearTimeout(this.typingtimer);
            }
            this.typingtimer = setTimeout(() => {
              this.usertyping = false;
            }, 2000);
          }
        });
    });

    this.getmessages(this.user);
  },

  watch: {
    user: function() {
      this.getmessages(this.user);
    }
  },
  methods: {

    getmessages(user) {
      axios.get("/messages/" + user).then(response => {
        this.messages = response.data.messages;

        this.ouser = response.data.user;
      });
    },
    sendTypingEvent() {
      window.Echo.private("pmessage_" + this.ouser.id).whisper(
        "typing",
        this.auth.id
      );
    },
    hidechat() {
      this.$emit("closechat");
    },
    sendmessage() {
      axios
        .post("/messages/" + this.user, { message: this.message })
        .then(response => {
          this.getmessages(this.user);
        })
        .catch(e => {
          console.log(e);
        });
      this.message = "";
      this.$emit("loadchats");
    }
  }
};
</script>

<style>
</style>
