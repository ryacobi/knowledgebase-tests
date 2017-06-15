<?php

	use PHPUnit\Framework\TestCase;
	use tad\FunctionMocker\FunctionMocker;

	/**
	 * @covers Email
	 */
	final class TopicIdTest extends \PHPUnit_Framework_TestCase
	{
 		public function setUp() {
        	 FunctionMocker::setUp();
    	}

	    public function test_metadata_delete_other_then_topic_id_return_empty_value() {
	    	// Arrage
	    	// Act
			$retvalue = prevent_topic_id_deletion(2, "my_meta_key", "my_meta_value");

			// Assert
	        $this->assertEmpty($retvalue);
	    }

	    public function test_metadata_delete_topic_id_return_true() {
	    	// Arrage
	    	// Act
			$retvalue = prevent_topic_id_deletion(2, "topic", "topic_id");

			// Assert
	        $this->assertTrue($retvalue);
	    }

	    public function test_itemNotPublished_topicIdNotCreated(){
	    	// Arrange
	    	$updatePostMeta = FunctionMocker::replace('update_post_meta', 0);
	    	FunctionMocker::replace('get_post_status', "draft");
			
			// Act
			$retValue = check_values_and_update_if_needed(5);

			// Assert
			$updatePostMeta->wasNotCalled();
	    }

	    public function test_itemPublished_topicIdExists_topicIdNotUpdated(){
	    	// Arrange
	    	$updatePostMeta = FunctionMocker::replace('update_post_meta', 0);
	    	FunctionMocker::replace('get_post_status', "publish");
	    	FunctionMocker::replace('get_field', function($field, $id){
	    		if ($field == "topic_id") return 5;
	    		if ($field == "open_to_users") return 1;
	    	});
			
			// Act
			$retValue = check_values_and_update_if_needed(5);

			// Assert
			$updatePostMeta->wasNotCalled();
	    }

	    public function test_itemPublished_itemNotOpenToUsers_topicIdNotCreated(){
	    	// Arrange
	    	$updatePostMeta = FunctionMocker::replace('update_post_meta', 0);
	    	FunctionMocker::replace('get_post_status', "publish");
	    	FunctionMocker::replace('get_field', function($field, $id){
	    		if ($field == "topic_id") return "";
	    		if ($field == "open_to_users") return 0;
	    	});
			
			// Act
			$retValue = check_values_and_update_if_needed(5);

			// Assert
			$updatePostMeta->wasNotCalled();
	    }

	    public function test_itemPublished_itemOpenToUsers_NoTopicId_topicIdCreated(){
	    	// Arrange
	    	$updatePostMeta = FunctionMocker::replace('update_post_meta', 0);
	    	FunctionMocker::replace('get_post_status', "publish");
	    	FunctionMocker::replace('get_post', new mockPost());
	    	FunctionMocker::replace('get_field', function($field, $id){
	    		if ($field == "topic_id") return 0;
	    		if ($field == "open_to_users") return 1;
	    	});
			
			// Act
			$retValue = check_values_and_update_if_needed(5);

			// Assert
			$updatePostMeta->wasCalledOnce();
	    }


	    public function test_topicIdCreated_withRightPattern(){
	    	// Arrange
	    	$updatePostMeta = FunctionMocker::replace('update_post_meta', 0);
	    	FunctionMocker::replace('get_post_status', "publish");
	    	FunctionMocker::replace('get_post', new mockPost());
	    	FunctionMocker::replace('get_field', function($field, $id){
	    		if ($field == "topic_id") return 0;
	    		if ($field == "open_to_users") return 1;
	    	});
			
			// Act
			$retValue = check_values_and_update_if_needed(5);

			// Assert
			$updatePostMeta->wasCalledWithOnce([5, 'topic_id', '5_myName']);
	    }

	    public function test_topicIdCreated_withRightPattern_fromLingotecParent(){
	    	// Arrange
	    	$_GET["document_id"] = 5;
	    	$updatePostMeta = FunctionMocker::replace('update_post_meta', 0);
	    	FunctionMocker::replace('get_post_status', "publish");
	    	FunctionMocker::replace('pll_get_post', "true");
	    	FunctionMocker::replace('get_post', function($postId){
				if ($postId == 123) return new mockPost();
	    	});
	    	FunctionMocker::replace('get_field', function($field, $id){
	    		if ($field == "topic_id") return 0;
	    		if ($field == "open_to_users") return 1;
	    	});
			
			// Act
			$retValue = check_values_and_update_if_needed(5);

			// Assert
			$updatePostMeta->wasCalledWithOnce([5, 'topic_id', '5_myName']);
	    }

	    public function test_topicIdCreated_parentOpenToUsers(){
	    	// Arrange
	    	$_GET["document_id"] = 5;
	    	$updatePostMeta = FunctionMocker::replace('update_post_meta', 0);
	    	FunctionMocker::replace('get_post_status', "publish");
	    	FunctionMocker::replace('pll_get_post', "true");
	    	FunctionMocker::replace('get_post', function($postId){
				if ($postId == 123) return new mockPost();
	    	});
	    	FunctionMocker::replace('get_field', function($field, $id){
	    		if ($field == "topic_id") return 0;
	    		if ($field == "open_to_users" && $id == 123) return 1;
	    	});
			
			// Act
			$retValue = check_values_and_update_if_needed(5);

			// Assert
			$updatePostMeta->wasCalledWithOnce([5, 'topic_id', '5_myName']);
	    }

	     public function tearDown(){
        	// after any other tear down method
    	    FunctionMocker::tearDown();
	    }
	}

	class mockPost {
	    	public $post_name = "myName";
	}

	class lingotekDocument{
		public $source = 123;
	}

	class Lingotek_Model{
		public function get_group_by_id($documentId){
			return new lingotekDocument;
		}
	}

