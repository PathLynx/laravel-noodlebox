<template>
    <div>
        <template v-for="category in categories">
            <table class="dsxui-listtable">
                <tr>
                    <td width="50">{{ category.id }}</td>
                    <td width="50">
                        <img :src="category.image" class="img-30 img-cover" alt="" v-if="category.image"/>
                        <div class="img-30 img-placeholder" v-else></div>
                    </td>
                    <td>
                        <span v-for="i in level" :key="i" class="text-primary font-weight-bold">—</span>
                        <span class="font-weight-bold">{{ category.name }}</span>
                    </td>
                    <td width="100">
                        <span class="el-icon-top sort-icon" @click="doIncrease(category.id)"></span>
                        <span class="el-icon-bottom sort-icon" @click="doDecrease(category.id)"></span>
                    </td>
                    <td width="200" class="text-right">
                        <div class="action-links">
                            <a @click="onAddChild(category.id)">{{ $t('category.addchild')}}</a>
                            <span>|</span>
                            <a @click="showEdit(category)">{{$t('common.edit')}}</a>
                            <span>|</span>
                            <a @click="showDelete(category.id)">{{$t('common.delete')}}</a>
                        </div>
                    </td>
                </tr>
            </table>
            <category-list-table
                    :categories="category.children"
                    :level="level+1"
                    :on-edit="onEdit"
                    :on-delete="onDelete"
                    :on-add-child="onAddChild"
                    :on-increase="onIncrease"
                    :on-decrease="onDecrease"
            />
        </template>
    </div>
</template>

<script>
export default {
    name: "CategoryListTable",
    props: {
        categories: [],
        level: 0,
        onDelete: {
            type: Function,
            default: function () {

            }
        },
        onEdit: {
            type: Function,
            default: function () {

            }
        },
        onAddChild: {
            type: Function,
            default: function () {

            }
        },
        onIncrease: {
            type: Function,
            default: function () {

            }
        },
        onDecrease: {
            type: Function,
            default: function () {

            }
        }
    },
    methods: {
        showEdit(c) {
            this.onEdit && this.onEdit(c);
        },
        showAddChild(p) {
            this.onAddChild && this.onAddChild(p);
        },
        showDelete(id) {
            this.onDelete && this.onDelete(id);
        },
        doIncrease(id) {
            this.onIncrease && this.onIncrease(id);
        },
        doDecrease(id) {
            this.onDecrease && this.onDecrease(id);
        }
    }
}
</script>

<style scoped>

</style>