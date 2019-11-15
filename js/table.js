let request = window.superagent;

Vue.component('demo-grid', {
  template: '#grid-template',
  props: {
    data: Array,
    columns: Array,
    filterKey: String
  },
  data: function () {
    let sortOrders = {}
    this.columns.forEach(function (key) {
      sortOrders[key] = 1
    })
    return {
      sortKey: '',
      sortOrders: sortOrders
    }
  },
  computed: {
    filteredData: function () {
      let sortKey = this.sortKey
      let filterKey = this.filterKey && this.filterKey.toLowerCase()
      let order = this.sortOrders[sortKey] || 1
      let data = this.data
      if (filterKey) {
        data = data.filter(function (row) {
          return Object.keys(row).some(function (key) {
            return String(row[key]).toLowerCase().indexOf(filterKey) > -1
          })
        })
      }
      if (sortKey) {
        data = data.slice().sort(function (a, b) {
          a = a[sortKey]
          b = b[sortKey]
          return (a === b ? 0 : a > b ? 1 : -1) * order
        })
      }
      return data
    }
  },
  filters: {
    capitalize: function (str) {
      return str.charAt(0).toUpperCase() + str.slice(1)
    }
  },
  methods: {
    sortBy: function (key) {
      this.sortKey = key
      this.sortOrders[key] = this.sortOrders[key] * -1
    }
  }
})
let array = [""];
let demo = new Vue({
  el: '#demo',
  data: {
    table_type: "words",
    searchQuery: '',
    gridColumns: ['id','word'],
    gridData:[],
  },
  methods: {
      get_word_table: function () {
        request
          .get("./php/pdo.php/table")
          .end((err,res) => {
              this.gridColumns =['id','word'];
              let jsons =JSON.parse(res.text);
              this.gridData = jsons;
          });
     },
     get_sentence_table: function () {
       request
         .get("./php/pdo.php/sentence_table")
         .end((err,res) => {
             this.gridColumns = ['id','word'];
             let jsons =JSON.parse(res.text);
             console.log(res.text)
             this.gridData = jsons;
         });
    },
      getcount: function () {
       request
         .get("./php/pdo.php/count")
         .end((err,res) => {
           let jsons =JSON.parse(res.text);
           this.gridColumns= ['Count','word'];
           // this.gridData = jsons;
           let count_res = Object.keys(jsons);
           let data =[{}];
           jsons.forEach(function(val,index,ar){
             let num = Number(val["Count"]);
             let add = {  word : val["word"],
                         Count : num ,
                      }; //trueになる
             data.push(add);
          });
          let js = data;
          console.log(js)
          console.log(jsons)
          this.gridData = js;

         });
     }
  }
})
