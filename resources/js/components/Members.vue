<template>
  <ul class="contacts-list">
    <li v-for="member in memberscomputed" :key="member.id">
      <div>
        <router-link :to="{path:'/chat', query:{userid:member.id}}" class="contact-link">
          <img class="contacts-list-img" src="../../../public/img/user.png">

          <div class="contacts-list-info">
            <span class="contacts-list-name">{{member.name}}</span>

            <span class="contacts-list-msg">
              <small>
                <i class="fa fa-circle text-success"></i> Online
              </small>
            </span>
          </div>
          <!-- /.contacts-list-info -->
        </router-link>
      </div>
    </li>
  </ul>
</template>

<script>
export default {
  props: ["user"],
  data() {
    return {
      members: []
    };
  },
  created() {

    Echo.join("membersonline")
      .here(user => {
        this.members = user;
      })
      .joining(user => {
        this.members.push(user);
      })
      .leaving(user => {
        this.members = this.members.filter(u => u.id != user.id);
      });
  },
  computed:{
      memberscomputed:function(){
          return this.members.filter(u => u.id != this.user);
      }
  }
};
</script>

<style scoped>
.contacts-list {
  color: #fff;
}
.contact-link {
  text-decoration: none;
}
</style>
