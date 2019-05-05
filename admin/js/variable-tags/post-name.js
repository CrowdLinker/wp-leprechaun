import VariableTag from './variable-tag-base';

const PostName = fabric.util.createClass(VariableTag, {
  type: "variableTag",

  initialize: function(options) {
    options || (options = {});

    options.label = '%post_name%'

    this.callSuper("initialize", options);
  }
});


export default PostName;