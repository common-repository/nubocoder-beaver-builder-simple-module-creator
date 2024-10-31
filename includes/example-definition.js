{
	"my-tab-1": {
		"title": "Tab 1",
		"sections": {
			"section-1": {
				"title": "Section 1",
				"fields": {
					"my_color_field": {
						"type": "color",
						"label": "Color Picker",
						"default": "333333",
						"show_reset": true,
						"show_alpha": true
					},
					"my_date": {
						"type": "date",
						"label": "My Date",
						"min": "2000-01-01",
						"max": "2018-12-31"
					}
				}
			},
			"section-2": {
				"title": "Section 2",
				"fields": {
					"my_editor_field": {
						"type": "editor",
						"media_buttons": true,
						"wpautop": true
					},
					"my_link_field": {
						"type": "link",
						"label": "Link Field",
						"show_target": true,
						"show_nofollow": true,
						"show_download": true
					},
					"my_photo_field": {
						"type": "photo",
						"label": "Photo Field",
						"show_remove": false
					}
				}
			}
		}
	},
	"my-tab-2": {
		"title": "Tab 2",
		"sections": {
			"section-1": {
				"title": "Section 1",
				"fields": {
					"my_select_field": {
						"type": "select",
						"label": "Select Field",
						"default": "option-1",
						"options": {
							"option-1": "Option 1",
							"option-2": "Option 2"
						}
					},
					"my_text_field": {
						"type": "text",
						"label": "Text Field",
						"default": "",
						"placeholder": "Placeholder text",
						"class": "my-css-class",
						"description": "Text displayed after the field",
						"help": "Text displayed in the help tooltip"
					}
				}
			},
			"section-2": {
				"title": "Section 2",
				"fields": {
					"my_textarea_field": {
						"type": "textarea",
						"label": "Textarea Field",
						"default": "",
						"placeholder": "Placeholder Text",
						"maxlength": "255",
						"rows": "6"
					},
					"my_timezone_field": {
						"type": "timezone",
						"label": "Time Zone",
						"default": "UTC"
					}
				}
			},
			"section-3": {
				"title": "Section 3",
				"fields": {
					"my_select_toggle_field": {
						"type": "select",
						"label": "Select Toggle Field",
						"default": "option-1",
						"options": {
							"option-1": "Option 1",
							"option-2": "Option 2"
						},
						"toggle": {
							"option-1": {
								"fields": [
									"my_text_field_three"
								]
							},
							"option-2": {
								"sections": [
									"section-4"
								]
							}
						}
					},
					"my_text_field_three": {
						"type": "text",
						"label": "Text Field",
						"default": "",
						"placeholder": "Placeholder text"
					}
				}
			},
			"section-4": {
				"title": "Section 4",
				"fields": {
					"my_text_field_four": {
						"type": "text",
						"label": "Text Field",
						"default": "",
						"placeholder": "Placeholder text"
					}
				}
			}
		}
	}
}