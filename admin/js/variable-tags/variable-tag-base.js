
// Use this as base class
const VariableTag = fabric.util.createClass(fabric.Rect, {
  type: "variableTag",

  initialize: function(options) {
    options || (options = {});

    this.callSuper("initialize", options);
    this.set("label", options.label || "%tag_name%");
  },

  toObject: function() {
    return fabric.util.object.extend(this.callSuper("toObject"), {
      label: this.get("label")
    });
  },

  _render: function(ctx) {
    this.callSuper("_render", ctx);

    ctx.font = "14px Helvetica";
    ctx.fillStyle = "#333";
    ctx.fillText(this.label, -this.width / 2, -this.height / 2 + 20);
  }
});

export default VariableTag;