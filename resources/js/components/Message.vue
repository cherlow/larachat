<template>

<div class="row">
  <div class="col-md-6  mt-4">
    <div class="direct-chat-contact">
                  <ul class="contacts-list">
                    <li v-for="(chat,index) in chats" :key="index"  >
                      <div v-if="chat.sender_id==auth.id">
                      <a href='/messages/' class="contact-link"  @click.prevent="loadmessages(chat.messengarable_id)">
                        <img class="contacts-list-img" src="../../../public/img/user.png">

                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            {{chat.messengarable_name}}

                            <small class="contacts-list-date float-right">{{chat.created_at|mydate}}</small>
                          </span>

                          <span class="contacts-list-msg">{{chat.latest_message}}</span>
                        </div>
                        <!-- /.contacts-list-info -->
                      </a>
                      </div>
                      <div v-else>
                         <a href="" class="contact-link" @click.prevent="loadmessages(chat.sender_id)">
                        <img class="contacts-list-img" src="../../../public/img/user.png">

                        <div class="contacts-list-info">
                       <span class="contacts-list-name" >
                            {{chat.sender_name}}

                            <small class="contacts-list-date float-right">{{chat.created_at|mydate}}</small>
                          </span>

                          <span class="contacts-list-msg">{{chat.latest_message}}</span>
                        </div>
                        <!-- /.contacts-list-info -->
                      </a>


                      </div>
                    </li>




                  </ul>
                  <!-- /.contacts-list -->
                </div>
  </div>
  <div class="col-md-6 mt-4" >
    <pmessage v-if="display" :user='display' v-on:closechat="hidechat" v-on:loadchats="loadchats">
    </pmessage>

   </div>
   </div>


</template>

<script>
export default {
  data(){
  return{
    chats:{},
    users:{},
    auth:[],

    display:false
  }


  },
  watch:{
      '$route.query.userid':function(userid){
          this.loadmessages(userid);
      }
  },

  created(){

      if(this.$route.query.userid){
          this.loadmessages(this.$route.query.userid);
      }


      axios.get('/userauth').then(response=>{
    this.auth=response.data;


       // listen for events

            window.Echo.private('pmessage_'+this.auth.id)
      .listen('SendMessage',(event)=>{

       this.loadchats();

      })
  })
this.loadchats();
  },
  methods:{


    loadchats(){

      axios.get('/loadchats').then(response=>{
        this.chats=response.data.chats;
        this.users=response.data.users;



      })


    },
    loadmessages($id){
      this.display=$id;

    },
    hidechat(){
      this.display=false;
    }

  }

}
</script>

<style scoped>

.direct-chat-contact{
    height: 360px;
    background: #222d32;
    color: #fff;
    overflow: auto;


}
.contact-link{
  text-decoration: none;
}

</style>
