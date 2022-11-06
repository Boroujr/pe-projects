import Todo from "./Todo.js";

export default class List {
	constructor( record ) {
		this.name = record.name;
		this.id = record.id;
		this.list = record.list;
		this.dateCreated = record.dateCreated;
		this.lastId = 0;
		this.trash = record.trash;
		this.buttonHandler();
	}
	initData() {
		this.list = this.rehydrateTodos( this.list );
		this.trash = this.rehydrateTodos( this.trash );
		this.renderTodos();
	}
	rehydrateTodos( data ) {
		return data.map( function( todoData ) {
			return new Todo( todoData );
		} );
	}
	add( content ) {
		let todoTemplate = {
			id: this.getUniqueID(),
			content,
			complete: false,
			dateCreated: new Date(),
		};
		const todo = new Todo( todoTemplate );
		this.list.push( todo );
		console.log(this.list)
		this.renderTodos();
	}
	findCardById( id ) {
		return this.list.find( ( todo ) => {
			return id == todo.id;
		} );
	}
	getUniqueID() {
		let found = this.findCardById( this.lastId );
		if ( found ) {
			this.lastId++;
			this.getUniqueID();
		}
		return this.lastId;
	}
	remove( id ) {
		let filtered = this.list.filter( function( todo ) {
			return todo.id != id;
		} );
		let removed = this.findCardById( id );
		removed.id = new Date();
		this.trash.push( removed );
		console.log( "removed", this.trash );
		this.list = filtered;
		this.renderTodos();
	}
	complete( id ) {
		this.findCardById( id ).toggleComplete();
		this.renderTodos();
	}
	renderTodos() {
		var template = "<ul>";
		this.list.forEach( function( todo ) {
			template += todo.render();
		} );
		template += "</ul>";
		this.$outlet = document.querySelector(
			`[data-list-id="${this.id}"] output-field`
		);
		this.$outlet.innerHTML = template;
	}
	renderList() {
		return `<todo-list data-list-id="${this.id}">
					<h2 class="notice-voice" >${this.name}</h2>
					<actions>
						<button class="remove-list">
						<picture>
							<svg viewBox="0 0 50 50" preserveAspectRatio="xMidYMid" width="50" height="50">
							   <line x1="0" y1="0" x2="50" y2="50" />
							   <line x1="50" y1="0" x2="0" y2="50" />
							</svg>
						</picture>
						</button>
					</actions>
					<form>
						<input-field>
							<label>What do you want To do?</label>
							<input minlength="1" type="text">
							<button class="add">Add</button>
						</input-field>
					</form>
					<output-field>
					</output-field>
				</todo-list>
		`;
	}
	buttonHandler() {
		window.addEventListener( "click", ( event ) => {
			event.preventDefault();

			if ( event.target.matches( `[data-list-id="${this.id}"] button.add` ) ) {
				// console.log(this.list);
				let $input = event.target.closest( "todo-list" )
					.querySelector( "input" );
				!$input.value ? alert( "please enter something" ) : this.add( $input.value );
				$input.value = "";
			}
			if ( event.target.matches( `[data-list-id="${this.id}"] button.remove` ) ) {
				const id = event.target.closest( "li" ).dataset.id;
				this.remove( id );
			}
			if ( event.target.matches( `[data-list-id="${this.id}"] button.complete` ) ) {
				const id = event.target.closest( "li" ).dataset.id;
				console.log(this.list);
				this.complete( id );
			}
			if (
				event.target.matches( `[data-list-id="${this.id}"] h2.notice-voice` )
				|| event.target.matches( `[data-list-id="${this.id}"] h3.calm-voice` )
			) {
				let $text = event.target;
				$text.innerHTML = `<input class="edit-text" type='text' value='${$text.innerHTML}'>`;
				let $input = $text.querySelector( "input.edit-text" );
				$input.addEventListener( "keypress", function( event ) {
					if ( event.code === "Enter" ) {
						$text.innerHTML = $input.value;
					}
				} );
			}
		} );
	}
}