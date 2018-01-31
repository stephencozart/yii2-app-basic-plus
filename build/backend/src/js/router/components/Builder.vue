<template>
    <div class="layout-wrapper">

        <div class="builder-device">
            <draggable-icon type="section" name="Section"></draggable-icon>
            <span :class="{current: deviceMode === device.slug }" v-for="device in devices" @click="setDeviceMode(device.slug)">{{ device.name }}</span>
        </div>
        <div class="builder-wrapper">
            <div class="builder-stage">
                <layout-element v-for="(section,si) in sections"
                                @handleDrop="dropHandler"
                                v-bind="section"
                                :key="'section-'+si">
                </layout-element>

            </div>
            <div class="builder-objects">
                <inspector></inspector>
            </div>
        </div>

    </div>
</template>
<script>
    import Inspector from '../../components/Inspector';
    import DraggableIcon from '../../components/elements/layouts/DraggableIcon';
    import { Section } from '../../objects';

    const map = {
        section: Section
    };

    export default {
        components: {
            Inspector,
            DraggableIcon
        },
        methods: {
            setDeviceMode(device) {
                this.$store.commit('DEVICE_MODE', device);
            },
            dropHandler(data) {
                let child = map[data.type];
                data.owner.children.push(child);
            }
        },
        computed: {
            deviceMode() {
                return this.$store.state.deviceMode;
            },
            devices() {
                return this.$store.state.devices;
            },
            iFrameSrc() {
                return '/admin/app/editor#/builder/editor';
            }
        },
        data() {
            return {
                sections: [
                    {
                        id: 1,
                        uniqueId: '1aefg3ca',
                        type: 'section',
                        className: 'section',
                        displayName: 'Section',
                        dropZone: true,
                        htmlId: '',
                        styles: {
                            desktop: {
                                minHeight: '100px',
                                paddingTop: '50px',
                                paddingRight: '',
                                paddingBottom: '50px',
                                paddingLeft: '',
                                marginTop: '',
                                marginRight: '',
                                marginBottom: '',
                                marginLeft: ''
                            },
                            tablet: {
                                minHeight: '50px',
                                paddingTop: '25px',
                                paddingRight: '',
                                paddingBottom: '25px',
                                paddingLeft: '',
                                marginTop: '',
                                marginRight: '',
                                marginBottom: '',
                                marginLeft: ''
                            }

                        },
                        children: [
                            {
                                id: 2,
                                uniqueId: '2aefg3ca',
                                type: 'div',
                                className: 'section-heading',
                                displayName: 'Column',
                                dropZone: true,
                                htmlId: '',
                                styles: {
                                    desktop: {
                                        minHeight: '',
                                        paddingTop: '',
                                        paddingRight: '',
                                        paddingBottom: '',
                                        paddingLeft: '',
                                        marginTop: '',
                                        marginRight: '',
                                        marginBottom: '',
                                        marginLeft: ''
                                    }
                                },
                                children: [
                                    {
                                        id: 3,
                                        type: 'h1',
                                        uniqueId: '3aefg3ca',
                                        className: 'section-heading-h1',
                                        displayName: 'H1',
                                        htmlId: '',
                                        styles: {
                                            desktop: {
                                                minHeight: '',
                                                paddingTop: '',
                                                paddingRight: '',
                                                paddingBottom: '',
                                                paddingLeft: '',
                                                marginTop: '',
                                                marginRight: '',
                                                marginBottom: '',
                                                marginLeft: ''
                                            }
                                        },
                                        text: 'Heading'
                                    }
                                ]

                            }
                        ]
                    }
                ]
            }
        }
    }
</script>
<style lang="scss">
    body {
        margin: 0;
        padding: 0;
    }
    .app-wrapper {
        .main {
            margin-left: 0;
            .content {
                padding: 0;
            }
        }
    }
    .builder-device {
        height: 56px;
    }
    .builder-wrapper {
        position: fixed;
        left: 0;
        top: 0;
        min-height: 100vh;
        width: 100vw;


        .builder-stage {
            background-color: #eeeeee;
            margin-right: 300px;
            margin-top: 56px;
            section {
                outline: 1px dotted #ffffff;
                position: relative;
                &:after {
                    content: 'section';
                    position: absolute;
                    right: 0;
                    bottom:0;
                    padding: 3px 10px;
                    font-size: .6rem;
                    background-color: rgba(0,0,0,.6);
                    color: #ffffff;
                }
            }
        }
        .builder-objects {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            background-color: #dddddd;
            position: fixed;
            right: 0;
            top: 56px;
            bottom: 0;
            width: 300px;
            overflow-x: auto;
            padding: 1rem;
            box-sizing: border-box;
            label, input {
                font-size: 10px;
            }
            input[type="text"] {
                width: 55px;
                text-align: center;
            }
        }
    }
    .builder-device {
        display: flex;
        justify-content: center;
        position: relative;
        z-index: 2;
        background-color: #cccccc;

        span {
            margin: 1rem 2rem;
            &.current {
                text-decoration: underline;
            }
        }
    }
    .inspector-set-top {
        display: flex;
        justify-content: center;
    }
    .inspector-set-x {
        display: flex;
        justify-content: center;
        align-items: center;
        span {
            font-size: 10px;
            margin-left: .5rem;
            margin-right: .5rem;
        }
    }
    .inspector-set-bottom {
        display: flex;
        justify-content: center;
    }
</style>