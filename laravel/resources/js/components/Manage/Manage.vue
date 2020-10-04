<template>
<div class="background">
   <div class="container">
        <div class="left_container">
            <div id="category">   
                    <div class="category_header">
                      <div style="margin-left:11px;">
                        停留場
                      </div>
                    </div>    
                    <div class="category_item_1">
                      <b-button variant="primary" class="button" @click="station_create()">
                        停留場登録
                      </b-button>
                      <b-button variant="primary" class="button" @click="station_update()">
                        停留場修正/削除
                      </b-button>
                    </div>

                    <div class="category_header2">
                      <div style="margin-left:11px;">
                        径路
                      </div>
                    </div>  
                    <div class="category_item_2">
                      <b-button variant="primary" class="button" @click="checkpoint_create()">
                        チェックポイント登録
                      </b-button>
                      <b-button variant="primary" class="button" @click="checkpoint_update()">
                        チェックポイント 修正/削除
                      </b-button>
                      <b-button variant="primary" class="button1" @click="path_create()">
                        径路登録
                      </b-button>
                      <b-button variant="primary" class="button" @click="path_update()">
                        径路修正/削除
                      </b-button>
                    </div>

                    <div class="category_header3">
                      <div style="margin-left:11px;">
                        自動運転車
                      </div>
                    </div>  
                    <div class="category_item_3">
                      <b-button variant="primary" class="button" @click="rc()">
                        自動運転車 修正/削除/登録
                      </b-button>
                    </div>
            </div>                    
        </div>  
        <div class="right_container">
          <div class="right_container_item1">
            <!-- map manage page -->
            <!-- id => 1 : station, path select -->
            <router-view v-if="id == 1"></router-view>  

            <!-- manage first page -->
            <!-- id => 0 : first page -->
            <b-col v-if="id == 0" style="line-height:550px; vertical-align:left;">
             <div id="manage_icon" >.</div>
           
            </b-col>
            

            <!-- rccar page -->
            <!-- id => 2 : rccar select -->
              <router-view v-if="id == 2"></router-view>  <!-- rc car -->
          </div>
        </div>
    </div>
</div>    
</template>

<script>
export default {
  name: "Manage",
  data() {
    return {
      id : 0 // id => 0 : first page, 1 : station, path select, 2 : rccar select
    };
  },
  methods: {
    // station create function
    station_create() {
      this.id = 1
      this.$router.push({ name: "Manage_station_create" }).catch(err => {})
    },
    // station update function
    station_update() {
      this.id = 1
      this.$router.push({ name: "Manage_station_update" }).catch(err => {})
    },
    // path create function
    path_create() {
      this.id = 1
      this.$router.push({ name: "Manage_path_create" }).catch(err => {})
    },
    // path update function
    path_update() {
      this.id = 1
      this.$router.push({ name: "Manage_path_update" }).catch(err => {})
    },
    // rccar manage function
    rc() {
      this.id = 2
      this.$router.push({ name: "Manage_rc" }).catch(err => {})
    },
    // checkpoint create function
    checkpoint_create() {
      this.id = 1
      this.$router.push({ name: "Manage_checkpoint_create" }).catch(err => {})
    },
    // checkpoint update function
    checkpoint_update() {
      this.id = 1
      this.$router.push({ name: "Manage_checkpoint_update" }).catch(err => {})
    }
  }
};
</script>

<style scoped>

.background{
     background-color: #E9E9F2;
     height: 685px;
}

.container{
    display:grid;
    grid-template-columns: 16% 83%;
    width: 100%;
    width: 2200px;
    max-width:1500px;
    background-color: #E9E9F2;
    margin-right: 40px;
}

#category{           
  margin-top: 30px;
  border-style: solid;
  border-width: 1px;
  border-color: #E6E9ED;
  background-color: white;
  border-radius: 15px;
  height: 640px;
}

.category_header{
  border-bottom:1.5px solid #E6E9ED;
  padding: 10px;
}

.category_item_1{ 
  padding: 10px;
}

.category_header2{
  border-bottom:1.5px solid #E6E9ED;
  padding: 10px;
}

.category_item_2{ 
  padding: 10px;
}

.category_header3{
  border-bottom:1.5px solid #E6E9ED;
  padding: 10px;
}

.category_item_3{
  margin-left:8px;
}

.button{ /* category button */
    background-color : white;
    border : none;
    margin-top : 5%;
    color:#929293;
    font-size: 0.9em;
}
.button1{ /* category checkpoint_update button */
    background-color : white;
    border : none;
    margin-top : 5%;
    color:#929293;
    font-size: 0.9em;
    margin-right: 20px;
}

.right_container{  /* manage map */
  margin-top:30px;
  border:1px solid #E6E9ED;
  margin-left: 30px;
  border-radius: 15px;
  background-color: white;
  width: 1240px;
}

#manage_icon{
  width: 1200px;
  height: 100%;
  background-image: url( "../../../../public/image/manage.jpg" );
  background-repeat: no-repeat;
  margin-right: 700px;
  color:white;
  margin-top: 60px;
}


</style>