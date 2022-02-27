<template>
    <!-- ============================
        START MENU SECTION
    ============================== -->
    <div class="show_from_left" id="menu">
        <div class="header_menu_inner mobile_nav">
            <ul>
                <template v-if="categories.length > 0" >
                    <template v-for="(category, categoryIndex) in categories">
                        <template v-if="category.subCategories && category.subCategories.length > 0">
                            <li class="has_child" data-toggle="collapse_m_nav" :data-target="'#mobSubCategory_'+category.id" :key="'mobCategoryIndex_'+categoryIndex" @click.prevent="mobExpandNextMenu($event)">
                                <a href="javascript:void(0)">{{category.name | capitalize}}</a>
                            </li>
                            <div class="show_from_left" :id="'mobSubCategory_'+category.id" :key="'mobSubCategory_'+categoryIndex">
                                <ul class="mobile_submenu">
                                    <template v-for="(subCategory, subCategoryIndex) in category.subCategories">
                                        <template v-if="subCategory.thirdcategory && subCategory.thirdcategory.length > 0">
                                            <li class="has_child"  v-bind:class="{'custom_has_child': subCategoryIndex == 0 }" data-toggle="collapse_m_nav" :data-target="'#mobThirdCategory_'+subCategory.id" :key="'mobSubCategoryIndex_'+subCategoryIndex" @click.prevent="mobExpandNextMenu($event)">
                                                <router-link :to="{ name: 'second-category', params: { parent: category.slug, sub:subCategory.slug }}">{{subCategory.name}}</router-link>
                                                <span class="back" v-if="subCategoryIndex == 0" @click.prevent="mobBackToTopMenu($event)">Back</span>
                                            </li>
                                            <div class="show_from_left" :id="'mobThirdCategory_'+subCategory.id" :key="'mobSubCategory_'+subCategoryIndex">
                                                <ul class="mobile_submenu">
                                                    <li v-for="(thirdCategory, thirdCategoryIndex) in subCategory.thirdcategory" :key="'mobThirdCategoryIndex_'+thirdCategoryIndex">
                                                        <router-link :to="{ name: 'third-category', params: { parent: category.slug, sub:subCategory.slug, third:thirdCategory.slug }}">{{thirdCategory.name}}</router-link>
                                                        <span class="back" v-if="thirdCategoryIndex == 0" @click.prevent="mobBackToTopMenu($event)">Back</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <li :key="'mobSubCategoryIndex_'+subCategoryIndex">
                                                <router-link :to="{ name: 'second-category', params: { parent: category.slug, sub:subCategory.slug }}">{{subCategory.name | capitalize}}</router-link>
                                                <span class="back" v-if="subCategoryIndex == 0" @click.prevent="mobBackToTopMenu($event)">Back</span>
                                            </li>
                                        </template>
                                    </template>
                                </ul>
                            </div>
                        </template>
                        <template v-else>
                            <li :key="'mobCategoryIndex_'+categoryIndex"><router-link :to="{ name: 'parent-category', params: { parent: category.slug }}">{{category.name | capitalize}}</router-link></li>
                        </template>
                    </template>
                </template>
            </ul>
        </div>
        <div class="close_h_menu" @click.prevent="mobCloseMenu">
            <span>Close</span>
        </div>
    </div>
    <!-- ============================
        END MENU SECTION
    ============================== -->
</template>
<script> 
    import defaultStore from '../../defaultStore'
    export default {
        name:'headerMobileMenuComponent',
        beforeCreate() {
            if (!(this.$store && this.$store.state && this.$store.state['defaultStore'])) {
                this.$store.registerModule("defaultStore", defaultStore);
            }
        },
        mounted(){ 
            this.menuPreloads(); 
        },
        filters: {
            capitalize: function (value) {
                if (!value) return ''
                value = value.toString()
                return value.replace(/(\w)(\w*)/g, function(g0,g1,g2){return g1.toUpperCase() + g2.toLowerCase();})
            },
        },
        computed: {
            categories:{
                get: function () {
                    return this.$store.getters['defaultStore/getCategories']
                },
                set: function (categories = []) {
                    this.$store.commit('defaultStore/setCategories', categories); 
                }
            },
        },
        methods: {
            menuPreloads(){
                // this.$store.dispatch('defaultStore/defaultCategories');
            },
            mobBackToTopMenu(e) {
                $(e.target).closest('.show_from_left').removeClass('open_h_menu');
            },
            mobExpandNextMenu(e) {
                if ($(e.target).hasClass('back') == false) {
                    var mNavId = $(e.target).closest('li').data('target');
                    $(mNavId).addClass('open_h_menu'); 
                }   
            },
            mobCloseMenu() {
                $('.show_from_left , .show_from_right').removeClass('open_h_menu');
                $('.menu').removeClass('open');
            },
        },
    }
</script>
<style scoped>
    .mobile_nav .has_child.custom_has_child::after {
        right: 90px;
    }
</style>