<template>
    <!-- ============================
        START MENU SECTION
    ============================== -->
    <div class="header_nav">
        <ul>
            <template v-if="categories.length > 0" >
                <template v-for="(category, categoryIndex) in categories">
                    <template v-if="category.subCategories && category.subCategories.length > 0">
                        <li data-toggle="collapse_slide" :data-target="'#deskSubCategory_'+categoryIndex" :key="'deskCategoryIndex_'+categoryIndex"><a href="javascript:void(0)">{{category.name | capitalize}}</a></li>
                        <div class="submenu" :id="'deskSubCategory_'+categoryIndex" :key="'deskSubCategory_'+categoryIndex">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-3" v-for="(subCategory, subCategoryIndex) in category.subCategories" :key="'deskSubCategoryIndex_'+subCategoryIndex">
                                        <div class="submenu_list">
                                            <h2><router-link :to="{ name: 'second-category', params: { parent: category.slug, sub:subCategory.slug }}">{{subCategory.name | capitalize}}</router-link></h2>
                                            <ul>
                                                <li v-for="(thirdCategory, thirdCategoryIndex) in subCategory.thirdcategory" :key="'deskThirdCategoryIndex_'+thirdCategoryIndex">
                                                    <router-link :to="{ name: 'third-category', params: { parent: category.slug, sub:subCategory.slug, third:thirdCategory.slug }}">{{thirdCategory.name | capitalize}}</router-link>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <li :key="'deskCategoryIndex_'+categoryIndex"><router-link :to="{ name: 'parent-category', params: { parent: category.slug }}">{{category.name | capitalize}}</router-link></li>
                    </template>
                </template>
            </template>
        </ul>
    </div>
    <!-- ============================
        END MENU SECTION
    ============================== -->
</template>
<script> 
    import defaultStore from '../../defaultStore'
    export default {
        name:'headerMenuComponent',
        beforeCreate() {
            if (!(this.$store && this.$store.state && this.$store.state['defaultStore'])) {
                this.$store.registerModule("defaultStore", defaultStore);
            }
        },
        mounted(){ 
            // this.hideAllSubmenu(); 
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
            hideAllSubmenu(){
                $('.h_o_dropdown').each(function() {
                    var dropdown4 = $(this);
                    dropdown4.hide();
                });
            },
            menuPreloads(){
                // this.$store.dispatch('defaultStore/defaultCategories');
            },
        },
    }
</script>