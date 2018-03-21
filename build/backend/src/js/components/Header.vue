<template>
    <header class="header">
        <button @click="$emit('toggle')" class="sidebar-toggle">
            <svg aria-hidden="true" data-fa-processed="" data-prefix="fas" data-icon="bars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-bars fa-w-14"><path fill="currentColor" d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z" class=""></path></svg>
        </button>
        <div class="header-search">
            <div class="input-group">
                <input placeholder="search" class="form-control header-search-input" v-model="searchQuery" />
            </div>
            <div v-if="searchResults && Object.keys(searchResults).length > 0" class="search-results">
                <div v-for="(group, groupKey) in searchResults" class="search-result-group">
                    <header class="search-results-header">{{ groupKey }}</header>
                    <ul class="search-results-list">
                        <li class="search-result-list-item" v-for="result in group">
                            <a @click="go(result)" @mouseover="focusOnHover" href="javascript:void(0)">
                                <div class="search-result-list-item-title">{{ result.title }}</div>
                                <div class="search-result-list-item-description">{{ result.description }}</div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
</template>
<script>
    import InputGroup from "bootstrap-vue/es/components/input-group/input-group";
    import _ from 'lodash';

    export default {
        components: {InputGroup},
        data() {
            return {
                searchQuery: '',
                searchResults: {}
            }
        },
        watch: {
            searchQuery(value) {
                if (value) {
                    this.$http.get('/admin/app/search?q='+value).then((response) => {
                        let items = {};
                        _.each(response.data.items, (item) => {
                            let key = 0;
                            if (items.hasOwnProperty(item.resource)) {
                                key = items[item.resource].length + 1;
                            } else {
                                items[item.resource] = [];
                            }
                            items[item.resource].push(item);

                        });

                        this.searchResults = items;
                    });
                } else {
                    this.searchResults = {};
                }

            }
        },
        methods: {
            focusOnHover(event) {
                event.target.focus()
            },
            go(result) {
                console.log(result);
                this.$router.push({
                    name: result.routeName,
                    params: {
                        id: result.id
                    }
                })
                this.searchResults = {};
                this.searchQuery = '';
            }
        }
    }
</script>
<style lang="scss">
    .header-search {
        position: relative;
        .search-results {
            position: absolute;
            max-height: 60vh;
            padding: .5rem 1rem;
            background-color: #ffffff;
            border: 1px solid #cccccc;
            border-radius: 2px;
            margin-top: 2px;
            box-shadow: 1px 1px 3px 0 #dddddd;
            width: 100%;
            overflow-y: scroll;
            .search-results-header {
                border-bottom: 1px solid #dddddd;
                font-weight: 700;
                opacity: .8;
                text-transform: uppercase;
                font-size: .9rem;
                margin-bottom: .3rem;
            }
            .search-results-list {
                list-style: none;
                padding: 0;
                margin: 0;
                margin-left: -.5rem;
                margin-right: -.5rem;
                >li {
                    >a {
                        display: block;
                        padding: .5rem;
                        border-radius: 3px;
                        line-height: normal;
                        color: inherit;
                        transition: all 250ms ease-in-out;
                        &:focus, &:hover {
                            background-color: #91278c;
                            color: #ffffff;
                            outline: none;
                            text-decoration: none;
                        }
                        .search-result-list-item-description {
                            opacity: .6;
                        }
                    }
                }
            }
        }
    }
</style>