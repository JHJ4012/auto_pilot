<template>
  <div id="container">
  <b-navbar class="nav">
    <b-navbar-nav>
      <b-nav-item id="title" to="/">ADAM</b-nav-item>
    </b-navbar-nav>
    <b-navbar-nav id="navbar-nav">
      <b-nav-item id="title2" to="/" >관제</b-nav-item>
      <b-nav-item id="title2" to="/statistics" >통계</b-nav-item>
      <b-nav-item id="title2" to="/manage" >관리</b-nav-item>
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