<template>
    <div class="content-block">
        <div class="console-title">
            <h2>资料设置</h2>
        </div>
        <section style="display: flex;">
            <div class="avatar-div">
                <div class="avatar"><img id="avatar-image" :src="userInfo.avatar" alt=""></div>
                <div class="avatar-content">
                    <a @click="showPicker=true">
                        更换头像
                    </a>
                </div>
                <div class="avatar-content">支持JPG,JPEG,GIF,PNG格式</div>
            </div>
            <div class="flex">
                <table class="dsxui-formtable">
                    <colgroup>
                        <col class="w70 cell-label">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <td class="cell-label">真实姓名</td>
                        <td>
                            <el-input size="medium" class="w300" v-model="profile.realname"></el-input>
                        </td>
                    </tr>
                    <tr>
                        <td class="cell-label">性别</td>
                        <td>
                            <el-radio :label="1" v-model="profile.gender">男</el-radio>
                            <el-radio :label="2" v-model="profile.gender">女</el-radio>
                            <el-radio :label="3" v-model="profile.gender">其他</el-radio>
                        </td>
                    </tr>
                    <tr>
                        <td class="cell-label">生日</td>
                        <td>
                            <el-date-picker
                                    class="w300"
                                    v-model="profile.birthday"
                                    type="date"
                                    placeholder="选择日期"
                                    value-format="yyyy-MM-dd"
                                    format="yyyy-MM-dd"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="cell-label">个人描述</td>
                        <td>
                            <el-input type="textarea" rows="3" v-model="profile.bio" placeholder="一句话介绍自己"/>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <el-button type="primary" size="medium" class="w100" @click="handleSave">更新资料
                            </el-button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <media-dialog :show.sync="showPicker" @confirm="handleSaveAvatar"/>
    </div>
</template>

<script>
import ApiService from "../utils/ApiService";

export default {
    name: "UserInfo",
    components: {},
    data() {
        let self = this;
        return {
            profile: {},
            avatar: null,
            props: {
                lazy: true,
                value: 'name',
                label: 'name',
                lazyLoad(node, resolve) {
                    const {level} = node;
                    const fid = node.data ? node.data.id : 0;
                    self.$get('/district/batchget?fid=' + fid).then(response => {
                        const items = response.data.items.map((o) => ({
                            ...o,
                            leaf: level >= 2
                        }));
                        resolve(items);
                    });
                }
            },
            cascaderValue: [],
            showPicker: false
        }
    },
    computed: {
        userInfo() {
            return this.$store.state.userInfo;
        }
    },
    mounted() {
        ApiService.get('/user/profile').then(response => {
            const {profile} = response.data;
            const {province, city, district} = profile;
            this.profile = profile;
            this.cascaderValue = [province, city, district];
            setTimeout(() => {
                this.$refs.cascader.panel.lazyLoad();
            }, 300);
        });
    },
    methods: {
        handleSave() {
            this.profile.province = this.cascaderValue[0];
            this.profile.city = this.cascaderValue[1];
            this.profile.district = this.cascaderValue[2];
            this.$post('/user/profile/update', {
                profile: this.profile
            }).then(response => {
                this.$showToast('资料更新成功', () => this.$router.go(0));
            });
        },
        handleSaveAvatar(d) {
            var avatar = d.image;
            this.$post('/user/avatar/update', {avatar}).then(response => {
                //this.$router.go(0);
                this.userinfo.avatar = response.data.avatar;
            });
        }
    },
}
</script>

<style scoped>

</style>
