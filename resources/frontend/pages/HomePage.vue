<template>
      <div v-if="homePage"> 
            <div v-html="homePage.sectionOne && homePage.sectionOne.content ? homePage.sectionOne.content : ''"></div>
            <!-- <section class="home_our_picks" v-if="homePage.latestItems">
                  <div class="h_our_picks_wrap">
                        <div class="h_our_picks_row">
                              <div class="h_our_picks_inner" v-for="(product, imageIndex) in homePage.latestItems" :key="'latestItem_' + imageIndex">
                                    <a href="#">
                                          <img :src="product.images && product.images.length > 0 ? ('/' + product.images[0].compressed_image_path) : ('/' + defaultImage.value)" :alt="'Hologram Product ' + product.style_no" class="img-fluid">
                                          <h2>{{product.style_no}}</h2>
                                          <p>USD${{product.price}}</p>
                                    </a>
                              </div>
                        </div>
                  </div>
            </section> -->
            <section class="home_our_picks" v-if="homePage.latestItems">
                  <div class="h_our_picks_wrap">
                        <div class="h_our_picks_row">
                              <div class="h_our_picks_inner" v-for="(product, imageIndex) in homePage.latestItems" :key="'latestItem_' + imageIndex">
                                    <router-link :to="{ name: 'single-product', params: { parent: product.slug }}">
                                          <img :src="product.images && product.images.length > 0 ? ('/' + product.images[0].compressed_image_path) : ('/' + defaultImage.value) | doubleSlashFilter" 
                                          :alt="'Hologram Product ' + product.style_no"  class="img-fluid">
                                          <h2>{{product && product.name ? product.name : 'No Specific Name'}}</h2>
                                          <p>{{product && product.brand && product.brand.name ? product.brand.name : 'Not Specific'}} | USD${{product.price | round(2)}}</p>
                                    </router-link>
                                    <div class="product_on_hover">
                                          <ul class="p_list">
                                                <li v-if="product.sizes.length == 0">Not specific</li>
                                                <li v-for="(size, sizeIndex) in product.sizes" :key="'productSize_' + product.style_no + '_' + sizeIndex">{{size.item_size}}</li>
                                          </ul>
                                          <ul class="p_icon" v-if="product.values && product.values.length > 0">
                                                <li v-for="(value, valueIndex) in product.values" :key="'productValues_' + product.style_no + '_' + valueIndex"><i :class="value.icon"></i></li>
                                          </ul>
                                    </div>
                              </div>
                        </div>
                  </div>
            </section>
            <!-- <div v-if="homePage.latestItems">
                  <section class="home_slide_area">
                        <div class="home_slide_wrap">
                              <VueSlickCarousel ref="c1" v-bind="sliderSettings" v-if="sliderItems && sliderItems.length > 0">
                                    <div class="home_slider_inner" v-for="(product, imageIndex) in sliderItems" :key="'latestItem_' + imageIndex">
                                          <div class="home_slider_inner_content">
                                                <a href="#">
                                                <img :src="product.images && product.images.length > 0 ? ('/' + product.images[0].compressed_image_path) : ('/' + defaultImage.value)" :alt="'Hologram Product ' + product.style_no" class="img-fluid">
                                                <h2>{{product.style_no}}</h2>
                                                <p>USD${{product.price}}</p>
                                                </a>
                                          </div>
                                    </div>
                              </VueSlickCarousel>
                        </div>
                  </section>
            </div> -->
            <div v-html="homePage.sectionThree && homePage.sectionThree.content ? homePage.sectionThree.content : ''"></div>
            <div v-html="homePage.sectionFour && homePage.sectionFour.content ? homePage.sectionFour.content : ''"></div>
            <div v-html="homePage.sectionFive && homePage.sectionFive.content ? homePage.sectionFive.content : ''"></div>
      </div> 
</template>
<script> 
      import pageStore from './pageStore'
      import VueSlickCarousel from 'vue-slick-carousel'
       import 'vue-slick-carousel/dist/vue-slick-carousel.css'
      // optional style for arrows & dots
      import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
        export default {
            name:'homePage',
             filters: {
                  doubleSlashFilter: function (value) {
                        return value.replace("//", "/");
                  },
                  round: function (value, decimals) {
                        if(!value) {
                              value = 0;
                        }

                        if(!decimals) {
                              decimals = 0;
                        }
                        var value = Number(value);
                        value = value.toFixed(decimals);

                        return value;
                  }
            },
            data(){
                  return {
                        sliderSettings: {
                              "dots": false,
                              "infinite": false,
                              "arrows":false,
                              "lazyLoad": "progressive",
                              "focusOnSelect": true,
                              "speed": 600,
                              "slidesToShow": 4,
                              "slidesToScroll": 1,
                              "initialSlide": 0,
                              "responsive": [
                              {
                                    "breakpoint": 1024,
                                    "settings": {
                                    "slidesToShow": 4,
                                    "slidesToScroll": 1,
                                    "infinite": true,
                                    "dots": true
                                    }
                              },
                              {
                                    "breakpoint": 600,
                                    "settings": {
                                    "slidesToShow": 2,
                                    "slidesToScroll": 1,
                                    "initialSlide": 0
                                    }
                              },
                              {
                                    "breakpoint": 480,
                                    "settings": {
                                    "slidesToShow": 2,
                                    "slidesToScroll": 1
                                    }
                              }
                              ]
                        }
                  }
            },
            components: {
                  VueSlickCarousel,
            },
            metaInfo(){
                  return { 
                        title: this.homePage ? this.homePage.static_page_title : 'Home - Hologram',
                        meta: [
                              { charset: 'utf-8' },
                              { name: 'viewport', content: 'width=device-width, initial-scale=1' },
                              { name: 'title', content: this.homePage && this.homePage.static_page_meta_title ? this.homePage.static_page_meta_title : 'Home Page Of Hologram'},
                              { name: 'description', content: this.homePage && this.homePage.static_page_meta_description ? this.homePage.static_page_meta_description : 'Hologram Home Page Content.'},
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
                  this.GetHomePage(); 
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
                        this.GetHomePage();
                  },
                  sliderItems() {
                        this.sliderSettings.slidesToShow = 1;
                        this.$nextTick(() => {
                              this.sliderSettings.slidesToShow = 4;
                        })
                  },
            },
            computed:{
                  successMessage() {            
                        return this.$store.getters['pageStore/getSuccessMessage'];
                  },
                  errorMessage() {            
                        return this.$store.getters['pageStore/getErrorMessage'];
                  },
                  homePage:{
                        get: function () {
                              return this.$store.getters['pageStore/getHomePage']
                        },
                        set: function (homePage = null) {
                              this.$store.commit('pageStore/setHomePage', homePage); 
                        }
                  },
                  sliderItems(){
                        return this.homePage ? this.homePage.latestItems : [];
                  }
            },
            methods:{ 
                  GetHomePage(){
                        this.$Progress.start()
                        this.$set(this, 'homePage', null);
                        this.$store.dispatch('pageStore/homePage');
                  }
            },
      }
</script>