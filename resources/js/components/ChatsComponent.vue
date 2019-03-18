<template>
  <div class="row">
    <div class="col-8">
      <div class="card card-default">
        <div class="card-header">Messages</div>
        <div class="card-body p-0">
          <ul class="list-unstyled" style="height:300px; overflow-y:scroll" v-chat-scroll>
            <li class="p-2" v-for="(message,index) in messages" :key="index">
              <strong>{{message.user.name}}</strong>
              {{message.message}}
            </li>
          </ul>
        </div>
        <input
          @keydown="sendTypingEvent"
          @keyup.enter="sendmessage"
          v-model="newmessage"
          type="text"
          name="message"
          placeholder="enter your message..."
          class="form-control"
        >
      </div>
      <span class="text-muted" v-if="typinguser">{{typinguser.name}} is typing</span>
    </div>
    <div class="col-4">
      <div class="card card-default">
        <div class="card-header">Active Users</div>
        <div class="card-body">
          <ul>
            <li class="py-2" v-for="(user,index) in users" :key="index">{{user.name}}</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["user"],
  data() {
    return {
      messages: [],
      newmessage: "",
      users: [],
      typinguser: false,
      typingtimer: false
    };
  },
  created() {
    Echo.join("chat")
      .here(user => {
        this.users = user;
      })
      .joining(user => {
        this.users.push(user);
      })
      .leaving(user => {
        this.users = this.users.filter(u => u.id != user.id);
      })
      .listen("MessageSent", event => {
        this.messages.push(event.message);
      })
      .listenForWhisper("typing", response => {
        this.typinguser = response;
        if (this.typingtimer) {
          clearTimeout(this.typingtimer);
        }
        this.typingtimer = setTimeout(() => {
          this.typinguser = false;
        }, 3000);
      });
    this.fetchmessages();
  },
  methods: {
    fetchmessages() {
      axios.get("/messages").then(response => {
        this.messages = response.data;
      });
    },
    sendmessage() {
      this.messages.push({
        user: this.user,
        message: this.newmessage
      });
      axios.post("/messages", { message: this.newmessage }).then(response => {
        this.newmessage = "";
      });
    },
    sendTypingEvent() {
      Echo.join("chat").whisper("typing", this.user);
    }
  }
};
</script>
