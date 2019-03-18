<template>
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <ul class="contacts-list">
        <h4 class="text-center">All User Accounts</h4>
        <!-- <span > -->
        <!-- <div v-for="useronline in usersonline" :key="useronline.id"> -->
        <li v-for="user in usercomp" :key="user.id">
          <!-- <div v-if="user.id !=auth.id"> -->
          <router-link :to="{path:'/chat', query:{userid:user.id}}" class="contact-link">
            <img class="contacts-list-img" src="../../../public/img/user.png">

            <div class="contacts-list-info">
              <span class="contacts-list-name">{{user.name}}</span>

              <span class="contacts-list-msg">
                <small>Member Since {{user.created_at|mydate}}</small>
              </span>
            </div>
            <!-- /.contacts-list-info -->
          </router-link>
          <!-- </div> -->
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: [],
      auth: []
    };
  },
  created() {
    this.getallusers();
    window.Echo.channel("newuser").listen("NewUser", event => {
      this.users.push(event.user);
      // console.log(event.user);
    });
  },
  methods: {
    getallusers() {
      axios.get("/userauth").then(res => {
        this.auth = res.data;
      });
      axios.get("/allusers").then(response => {
        this.users = response.data;
      });
    }
  },
  computed: {
    usercomp: function() {
      return this.users.filter(u => u.id != this.auth.id);
    }
  }
};
</script>

<style scoped>
.contacts-list {
  color: #fff;
  background: #222d32;
}
.contact-link {
  text-decoration: none;
}
</style>
