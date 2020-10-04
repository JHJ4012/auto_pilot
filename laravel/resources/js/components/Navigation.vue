<template>
  <div id="container">
  <b-navbar class="nav">
    <b-navbar-nav>
      <b-nav-item id="title" to="/">バリバリ</b-nav-item>
    </b-navbar-nav>
    <b-navbar-nav id="navbar-nav">
      <b-nav-item id="title2" to="/" >管制</b-nav-item>
      <b-nav-item id="title2" to="/statistics" >統計</b-nav-item>
      <b-nav-item id="title2" to="/manage" >管理</b-nav-item>
    </b-navbar-nav>
  </b-navbar>
  </div>
</template>
<script>
export default {
    name: 'Nav'
}
</script>

<style scoped>
#container{
  background-color: #E9E9F2;
}
.nav {
margin-left: 15px;
font-size: 1.4em;
width: 1505px;
border-style: solid;
border-width: 1px;
border-color: #E6E9ED;
border-radius: 15px;
background-color:white;
}
.nav-item{
  margin-right : 100px;
}

#title{
  margin-left: 20px;
}

#navbar-nav{
  margin-left: 760px;
}
</style>