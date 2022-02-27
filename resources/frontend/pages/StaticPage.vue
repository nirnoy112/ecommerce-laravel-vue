<template>
      <section class="product_single_area" style="min-height:60vh"> 
            <div class="static_page_wrapper" v-if="staticPage && staticPage.content" v-html="staticPage.content"> </div> 
            <div class="static_page_wrapper" v-else> Contents not found</div> 
            <p v-if="staticPage">{{staticPage.static_page_title}}</p>
      </section>
</template>
<script>  
      import pageStore from './pageStore'
      export default {
            name:'StaticPage',
            metaInfo(){
                  return { 
                        title: this.staticPage ? this.staticPage.static_page_title : 'Hologram Pages',
                        meta: [
                              { charset: 'utf-8' },
                              { name: 'viewport', content: 'width=device-width, initial-scale=1' },
                              { name: 'title', content: this.staticPage && this.staticPage.static_page_meta_title ? this.staticPage.static_page_meta_title : 'Hologram Pages'},
                              { name: 'description', content: this.staticPage && this.staticPage.static_page_meta_description ? this.staticPage.static_page_meta_description : 'Hologram Pages'},
                        ]
                  }
            },
            beforeCreate() {
                  if (!(this.$store && this.$store.state && this.$store.state['pageStore'])) {
                        this.$store.registerModule("pageStore", pageStore);
                  }
            }, 
            beforeDestroy() {            
                  // if ((this.$store && this.$store.state && this.$store.state['pageStore'])) {
                  //       this.$store.unregisterModule('pageStore');
                  // }
            },
            mounted(){ 
                  this.GetStaticPage(); 
            },
            watch: {
                  successMessage(successMessage) {
                        if (successMessage) {
                              toast.fire({
                                    icon: 'success',
                                    title: successMessage
                              })                    
                              this.$store.commit('pageStore/setSuccessMessage', ''); 
                        }
                  },
                  errorMessage(errorMessage) {
                        if (errorMessage) {
                              toast.fire({
                                    icon: 'error',
                                    title: errorMessage
                              })
                              this.$store.commit('pageStore/setErrorMessage', ''); 
                        }
                  },
                  $route(to,from){
                        this.GetStaticPage();
                  }
            },
            computed:{
                  successMessage() {            
                        return this.$store.getters['pageStore/getSuccessMessage'];
                  },
                  errorMessage() {            
                        return this.$store.getters['pageStore/getErrorMessage'];
                  },
                  staticPage:{
                        get: function () {
                              return this.$store.getters['pageStore/getStaticPage']
                        },
                        set: function (staticPage = null) {
                              this.$store.commit('pageStore/setStaticPage', staticPage); 
                        }
                  },
            },
            methods:{ 
                  GetStaticPage(){
                        this.$Progress.start()
                        this.$set(this, 'staticPage', null);
                        let payloadId = null;
                        let path = this.$route.path;
                        switch (path) {
                              case '/':
                                    payloadId = 1;
                                    break;
                              case '/about-us':
                                    payloadId = 2;
                                    break;
                              case '/contact-us':
                                    payloadId = 3;
                                    break;
                              case '/privacy-policy':
                                    payloadId = 4;
                                    break;
                              case '/terms-conditions':
                                    payloadId = 6;
                                    break;
                              case '/shipping-returns':
                                    payloadId = 7;
                                    break;
                              case '/size-chart':
                                    payloadId = 8;
                                    break;
                              case '/faq':
                                    payloadId = 19;
                                    break;
                              default:
                                    payloadId = null;
                                    break;
                        }
                        this.$store.dispatch('pageStore/staticPage',payloadId);
                  }
            },
      }
</script>