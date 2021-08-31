
(function() {
	
	function PopMem(args) {
		
		this.title    = args.title || "";
		this.content  = args.content || "";
		this.isModal  = (typeof args.isModal === "boolean") ? args.isModal : true;
		this.moveable = (typeof args.moveable === "boolean") ? args.moveable : true;
		this.document = args.document || document;
	
		this.isDown = false;  
		this.offset = {
            "width": 0, 
            "height": 0
        };
        this.id = ++top.PopMem.id;
		
		var modal = this.getElement();
		if (this.isModal) {
			this.myModal = modal.myModal;
		}
		this.myPop = modal.myPop;
        top.PopMem.instances[this.id] = this;
		
		this.init();
	};
	
	PopMem.prototype = {
		
		init: function() {
			this.initContent();
			this.initEvent();
		},
		
		initContent: function() {
			if (this.isModal) {
                $("body", this.document).append(this.myModal);
                this.myModal.show();
            }
			$("body", this.document).append(this.myPop);
            $(".myPop-title-values", this.myPop).html(this.title);
            this.myPop.css("top", (this.document.documentElement.clientHeight - this.myPop.height()) / 2 + "px");
			this.myPop.css("left", (this.document.documentElement.clientWidth - this.myPop.width()) / 2 + "px");
            this.myPop.show();
		},
		
		initEvent: function() {
			var $this = this;
			
			$(".myPop-title", this.myPop).on("mousedown", function(e) {
				$this.isDown = true;
				var event = window.event || e;
				
				$this.offset.height = event.clientY - $this.myPop.offset().top;
				$this.offset.width = event.clientX - $this.myPop.offset().left;
                return false;
			});
			
			$(this.document).mousemove(function(e) {
				 if ($this.isDown && $this.moveable) {
			        var event = window.event || e;
			        
			        var top = event.clientY - $this.offset.height,
                    left = event.clientX - $this.offset.width,
                    maxL = $this.document.documentElement.clientWidth - $this.myPop.width(),
                    maxT = $this.document.documentElement.clientHeight - $this.myPop.height();        
                    
					left = left < 0 ? 0 : left;
                    left = left > maxL ? maxL : left;      
                    top = top < 0 ? 0 : top;
                    top = top > maxT ? maxT : top;
					
					$this.myPop.css("top", top + "px");
					$this.myPop.css("left", left + "px");
					
				}
                return false;
			}).mouseup(function(e) {
				if ($this.isDown) {
					$this.isDown = false;
				}
                return false;
            });
			
			$(".myPop-closes", this.myPop).on('click', function() {
                $this.destroy();
                return false;
            });
			
			$(".myPop-contents-footer-right", this.myPop).on('click', function() {
                $this.destroy();
                return fals
			 });
			 
			
			
		},
        
		getElement: function() {
			return {
				"myModal": $("<div class='myModals'></div>", this.document),
				"myPop": $("<div class='myPops'>" +
                                "<h2 class='myPop-titles'>" +
                                    "<span class='myPop-title-values'></span>" + 
                                    "<span class='myPop-closes'><img src='admin/jlib/bclose.fw.png' /></span>" +  
                                "</h2>" + 
                                "<div class='myPop-contents'><div class='myPop-contents-body'>" + this.content + "</div><div class='myPop-contents-footer'><div class='myPop-contents-footer-right'><img src='admin/jlib/okButtons.fw.png' /></div></div></div>" + 
                           "</div>", this.document)
			};
		},
		
		destroy: function() {
			
			this.myPop.remove();
			
			if(this.isModal){
				this.myModal.remove();
			}
            
			delete top.PopMem.instances[this.id];
			
			top.PopMem.id--;
		}
	};
	
    if (!top.PopMem) {
		PopMem.zIndexCounter = 1000;
		PopMem.id = 0;
		PopMem.instances = {};
		
		top.PopMem = PopMem;
	}
    
})();